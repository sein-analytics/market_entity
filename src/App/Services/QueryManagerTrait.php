<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/29/17
 * Time: 10:33 AM
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\Mapping\ClassMetadata;
trait QueryManagerTrait
{

    /** @var  EntityManager */
    protected $em;

    static $base = 'App\\Entity\\';

    static $wrongArrayLen = ['message' => 'Insert array size is wrong'];

    static $missingColVal = ['message' => 'Insert array is missing a column data'];

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $tableName
     * @return bool|int
     */
    public function fetchNextAvailableTableId(string $tableName)
    {
        $schemaManager = $this->em->getConnection()->getSchemaManager();
        if(!$schemaManager->tablesExist(array($tableName))){
            return false;
        }
        $sql = "SELECT MAX(id) FROM $tableName";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC)['MAX(id)'] + 1;
        return $result;
    }

    /**
     * @param string $name
     * @return bool|\ReflectionClass
     */
    public function entityReflectorFromEntityName(string $name)
    {
        if(!class_exists($name)){
            return false;
        }
        return new \ReflectionClass($name);
    }

    public function entityPropertiesFromReflector(\ReflectionClass $reflector)
    {
        if(! $reflector->hasMethod('createEntityPropertiesArray')){
            return false;
        }
        $class = $reflector->getName();
        return $reflector->getMethod('createEntityPropertiesArray')->invoke(new $class);
    }

    /**
     * @param string $tableName
     * @return bool|array
     */
    public function fetchEntityMetaData(string $tableName)
    {
        if(!$this->doesEntityTableExist($tableName)){
            return false;
        }
        try {
            $meta = $this->em->getMetadataFactory()->getMetadataFor(self::$base . $tableName);
            return $meta->getColumnNames();
        }catch (\Exception $exception){
            return false;
        }
    }

    public function doesEntityTableExist($tableName)
    {
        $schemaManager = $this->em->getConnection()->getSchemaManager();
        return $schemaManager->tablesExist($tableName);
    }

    public function buildInsertSqlStatement(string $tableName){
        $columns = implode(",", array_keys(self::$table));
        $sqlInsertLine = self::INSERT__SQL_START . "$tableName ($columns) VALUES" . PHP_EOL;
        return $sqlInsertLine;
    }

    public function buildUpdateElementStatement(array $data, string $tableName, int $id)
    {
        $size = count(self::$table); $counter = 0; $updateStmt = "UPDATE $tableName SET ";
        reset(self::$table);
        foreach (self::$table as $colName => $properties){
            if (!array_key_exists($counter, $data)){
                $counter++;
                continue;
            }
            if (($value = $this->returnInsertArrayValue($data, $counter, $colName)) === false)
                return self::$missingColVal;
            $typeResult = $this->isTypeMappingCorrect(gettype($value), $colName, $properties);
            if(is_array($typeResult))
                return $typeResult;
            $value = $this->quoteStringValue($value, $properties);
            $value = $this->boolToIntValue($value);
            $updateStmt .= PHP_EOL . $colName . ' = ' . $value . (($counter < $size -1) ? ',' : '');
            $counter++;
        }
        $updateStmt .= PHP_EOL . " WHERE id = $id;";
        return $updateStmt;
    }

    public function buildInsertElementStatement(array $data, $ensureSize=true){
        $size = count(self::$table);
        if(count($data) !== $size &&  $ensureSize){
            return self::$wrongArrayLen;
        }
        reset(self::$table);
        $counter = 0;
        $insertStmt = '(';
        foreach (self::$table as $colName => $properties){
            if (($value = $this->returnInsertArrayValue($data, $counter, $colName)) === false)
                return self::$missingColVal;
            if(is_null($value)) {
                $value = $this->isValueNullable($value, $colName, $properties);
                if(is_array($value)){
                    return $value;
                }
            }
            $typeResult = $this->isTypeMappingCorrect(gettype($value), $colName, $properties);
            if(is_array($typeResult)){
                return $typeResult;
            }

            $value = $this->quoteStringValue($value, $properties);
            $value = $this->boolToIntValue($value);
            $insertStmt .= $value . $this->sqlEndingByCountSize($counter, $size - 1);
            $counter++;
        }
        return $insertStmt;
    }

    public function returnInsertArrayValue(array $insertData, int $counter, string $colName)
    {
        if (array_key_exists($colName, $insertData))
            return $insertData[$colName];
        elseif (array_key_exists($counter, $insertData))
            return $insertData[$counter];
        return false;
    }

    public function quoteStringValue($value, array $properties){
        if(!is_array($properties[self::DATA_TYPE])
            && $properties[self::DATA_TYPE] == 'decimal'){
            return $value;
        }
        if(is_array($properties[self::DATA_TYPE])
            && in_array('decimal', $properties[self::DATA_TYPE])){
            return $value;
        }
        if($properties[self::DATA_TYPE] == 'json'){
            $obj = json_decode($value, true);
            if(json_last_error() == JSON_ERROR_NONE){
                return $value = "'" . json_encode($obj) . "'";
            }
            return $value;
        }
        if(is_string($value) && $value !== 'NULL'){
            $value = '"' . $value . '"';
        }
        return $value;
    }

    /**
     * @param $bool
     * @return int
     */
    public function boolToIntValue($bool){
        if (!is_bool($bool)){
            return $bool;
        }
        if($bool === true){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @param $value
     * @param $colName
     * @param array $properties
     * @return array|mixed
     */
    public function isValueNullable($value, $colName, array $properties)
    {
        if ($properties[self::DATA_DEFAULT] !== 'NOT NULL') {
            $value = $properties[self::DATA_DEFAULT];
        } else {
            return ['message' => "property: $colName cannot be null"];
        }
        return $value;
    }

    /**
     * @param $type
     * @param string $propName
     * @param array $properties
     * @return array|bool ToDo we need to rewrite this method 24 if-else statements is untestable
     */
    public function isTypeMappingCorrect($type, string $propName, array $properties)
    {
        return true;
    }

    /**
     * @param int $count
     * @param int $size
     * @return string
     */
    public function sqlEndingByCountSize(int $count, int $size){
        if($count == 0){
            return ',';
        } elseif($count > 0 && $count < $size) {
            return ',';
        } else{
            return '),' . PHP_EOL;
        }
    }

    /**
     * @param string $columnName
     * @return bool|int
     */
    public function fetchTableColumnNumericalIndex(string $columnName)
    {
        $counter = 0;
        foreach (self::$table as $col => $props){
            if ($col === $columnName){
                return $counter;
            }
            $counter++;
        }
        return false;
    }
}
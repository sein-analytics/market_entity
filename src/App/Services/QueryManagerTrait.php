<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/29/17
 * Time: 10:33 AM
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;

trait QueryManagerTrait
{

    /** @var  EntityManager */
    protected $em;

    static $base = 'App\\Entity\\';

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
     * @return bool|\Doctrine\Common\Persistence\Mapping\ClassMetadata
     */
    public function fetchEntityMetaData(string $tableName)
    {
        if(!$this->doesEntityTableExist($tableName)){
            return false;
        }
        $meta = $this->em->getMetadataFactory()->getMetadataFor(self::$base . $tableName);
        return $meta->getColumnNames();
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

    public function buildInsertElementStatement(array $data){
        if(count($data) !== count(self::$table)){
            return ['message' => 'Insert array size is wrong'];
        }
        reset(self::$table);
        $size = count(self::$table);
        $counter = 0;
        $insertStmt = '(';
        foreach (self::$table as $colName => $properties){
            $value = $data[$counter];
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
            if(is_string($value)){
                $value = '"' . $value . '"';
            }
            $insertStmt .= $value . $this->sqlEndingByCountSize($counter, $size - 1);
            $counter++;
        }
        return $insertStmt;
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
     * @return array|bool
     */
    public function isTypeMappingCorrect($type, string $propName, array $properties)
    {
        if(array_key_exists($type , self::TYPE_MAPPER)){
            if(is_array(self::TYPE_MAPPER[$type])){
                if(in_array($properties[self::DATA_TYPE], self::TYPE_MAPPER[$type])){
                    return true;
                }
            }else{
                if($properties[self::DATA_TYPE] == self::TYPE_MAPPER[$type]){
                    return true;
                }
                return ['message' => "Type $type for $propName is not appropriate"];
            }
        }else {
            return ['message' => "Type $type for $propName is not appropriate"];
        }
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
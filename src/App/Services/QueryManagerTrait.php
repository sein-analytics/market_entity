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
        return $meta;
    }

    public function doesEntityTableExist($tableName)
    {
        $schemaManager = $this->em->getConnection()->getSchemaManager();
        return $schemaManager->tablesExist($tableName);
    }
}
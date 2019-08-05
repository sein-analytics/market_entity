<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 11:18 AM
 */

namespace App\Service;


use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

trait FetchingTrait
{
    /**
     * @param EntityManager $em
     * @param array $keys
     * @param string $sql
     * @return array|bool
     */
    public function fetchByIntArray(EntityManager $em, array $keys, string $sql){
        if(!count($keys) > 0) { return false; }
        $stmt = $this->returnInArraySqlStmt($em, $keys, $sql);
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    /**
     * @param string $key
     * @param array $array
     * @return array
     */
    public function array_value_recursive(string $key, array $array)
    {
        $val = [];
        array_walk_recursive($array, function ($v, $k) use($key, &$val) {
            if ($k == $key) array_push($val, $v);
        });
        return $val;
    }

    /**
     * @param EntityManager $em
     * @param array $keys
     * @param string $sql
     * @return \Doctrine\DBAL\Driver\Statement
     */
    public function returnInArraySqlStmt(EntityManager $em, array $keys, string $sql)
    {
        $stmt = $em->getConnection()->executeQuery($sql,
            array($keys),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        return $stmt;
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param array[] ...$keys
     * @return \Doctrine\DBAL\Driver\Statement
     */
    public function returnMultiIntArraySqlStmt(EntityManager $em, string $sql, array ...$keys)
    {
        $intParams = [];
        $base = array_reduce($keys, function ($result, $item) use(&$intParams) {
            $result[] = $item;
            array_push($intParams, Connection::PARAM_INT_ARRAY);
            return $result;
        }, []);
        $stmt = $em->getConnection()->executeQuery($sql, $base, $intParams);
        return $stmt;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 11:18 AM
 */

namespace App\Service;


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

}
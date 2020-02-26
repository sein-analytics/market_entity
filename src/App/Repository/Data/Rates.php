<?php


namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

abstract class Rates extends EntityRepository
{
    public function fetchRates(string $table)
    {
        $sql = "SELECT value FROM $table WHERE id > 0";
        try {
            $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql);
        } catch (\Exception $e){
            return false;
        }
        return $stmt->fetchAll(Query::HYDRATE_ARRAY);
    }
}
<?php


namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

abstract class Rates extends EntityRepository
{
    public function fetchRates(string $table)
    {
        $sql = "SELECT name, value FROM $table";
        try {
            $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql);
        } catch (\Exception $e){
            return false;
        }
        return $stmt->fetchAll(Query::HYDRATE_ARRAY);
    }
}
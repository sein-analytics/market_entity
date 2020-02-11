<?php


namespace App\Repository\Data;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Treasuries extends EntityRepository
{
    public function fetchRates()
    {
        $sql = "SELECT * FROM Treasuries";
        $result = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $result;
    }
}
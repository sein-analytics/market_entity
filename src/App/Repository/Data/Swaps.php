<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 3/13/18
 * Time: 10:00 AM
 */

namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Swaps extends EntityRepository
{
    public function fetchSwapRates()
    {
        $sql = "SELECT * FROM Swaps";
        $result = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 12/5/17
 * Time: 10:23 AM
 */

namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class State extends EntityRepository
{
    public function fetchAllStates()
    {
        $sql = "SELECT * FROM State";
        $result = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $result;
    }
}
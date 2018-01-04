<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/3/18
 * Time: 12:39 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BidStatus extends EntityRepository
{
    /**
     * @return array
     * @throws \Exception
     */
    public function fetchAllBidStatus()
    {
        $sql = "SELECT * FROM BidStatus WHERE id > 0";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        if(!$result) { throw new \Exception("Could not fetch BidStatus data", 400); }
        $base = [];
        foreach ($result as $int => $status){
            $base[$status['id']] = $status['status'];
        }
        return $base;
    }

}
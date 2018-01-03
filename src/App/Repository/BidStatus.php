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
    public function fetchAllBidStatus()
    {
        $sql = "SELECT * FROM DealStatus";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $result;
    }

}
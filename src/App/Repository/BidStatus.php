<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/3/18
 * Time: 12:39 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class BidStatus extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;
    /**
     * @return array
     * @throws \Exception
     */
    public function fetchAllBidStatus()
    {
        $sql = "SELECT * FROM BidStatus";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $temp = $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        if(!$result) { throw new \Exception("Could not fetch BidStatus data", 400); }
        return $this->idToStatusMapper($result);
    }

}
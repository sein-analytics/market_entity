<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/4/18
 * Time: 11:21 AM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DealStatus extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;

    public function fetchAllDealStatuses(){
        $sql = "SELECT * FROM DealStatus";
        $stmt = $this->getEntityManager()
            ->getConnection()
            ->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        if(!$result) { throw new \Exception("Could not fetch DealStatus data", 400); }
        return $this->idToStatusMapper($result);
    }
}
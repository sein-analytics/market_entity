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
    implements DbalStatementInterface
{
    use FetchMapperTrait, FetchingTrait;

    private string $fetchAllBidStatusSql = "SELECT * FROM BidStatus";

    /**
     * @return array
     * @throws \Exception
     */
    public function fetchAllBidStatus()
    {
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAllBidStatusSql,
            self::FETCH_ALL_ASSO_MTHD,
            []
        );

        if(!$result) { throw new \Exception("Could not fetch BidStatus data", 400); }
        return $this->idToStatusMapper($result);
    }

}
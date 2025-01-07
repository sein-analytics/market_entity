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
use App\Repository\DbalStatementInterface;

class DealStatus extends EntityRepository
    implements DbalStatementInterface
{
    private string $fetchAllDealStatusesSql = "SELECT * FROM DealStatus";

    use FetchMapperTrait, FetchingTrait;

    public function fetchAllDealStatuses(){
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAllDealStatusesSql,
            self::FETCH_ALL_ASSO_MTHD,
            []
        );

        if(!$results) { throw new \Exception("Could not fetch DealStatus data", 400); }
        return $this->idToStatusMapper($results);
    }
    
}
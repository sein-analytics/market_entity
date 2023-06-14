<?php

namespace App\Repository;

use App\Repository\Bid\BidInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class KickOutsLoan extends EntityRepository
    implements DbalStatementInterface, BidInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $insertKickOutSql = "INSERT INTO KickOutLoan VALUE (null, ?, ?, ?, ?)";

    private string $kickOutsByBidIdsSql = "SELECT * FROM KickOutLoan WHERE bidId IN ()";

    private array $tableProps = [
        self::KO_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
        self::KO_BID_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::BID_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::KO_POOL_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::POOL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::KO_DEAL_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DEAL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
    ];

    public function insertNewKickOutLoan (array $params)
    {
        if (array_key_exists(self::KO_ID_KEY, $params))
            unset($params[self::KO_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertKickOutSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function fetchKickOutsByBidIds(array $bids)
    {
        $stmt = $this->returnMultiIntArraySqlStmt(
            $this->getEntityManager(), $this->kickOutsByBidIdsSql, $bids
        );
        try{
            $results = $stmt->fetchAllAssociative();
        }catch (\Doctrine\DBAL\Driver\Exception $err){
            $results = ["message" => $err->getMessage()];
        }
        return $results;
    }

    public function returnTablePropsArray () :array { return  $this->tableProps; }
}
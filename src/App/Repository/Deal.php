<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:32 PM
 */

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Repository\Deal\DealAbstract;

class Deal extends DealAbstract
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;
    
    static $table = [
        'id'=> [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'issuer_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'status_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'auction_type_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'asset_type_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'bid_type_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'user_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'issue' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'cut_off_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'closing_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'payment_day' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'current_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'original_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'prior_o_c' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'cashflow_engine' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'call_formular'  => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'loan_data_parser'  => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'views' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'latest_period_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
    ];

    private string $fetchUserDealAccessSql = "SELECT * FROM deal_market_user WHERE market_user_id=? AND deal_id=?";

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    public function fetchDealPoolIdsByDealId(int $id)
    {
        $sql = "SELECT id FROM Pool Where deal_id = :deal_id";
        try {
            $stmt = $this->em->getConnection()->prepare($sql);
        } catch (\Exception $exception){
            return false;
        }
        $stmt->bindValue('deal_id', $id);
        return $this->completeIdFetchQuery($stmt);
    }

    public function fetchDealBidTypeIdByDealId(int $id)
    {
        $sql = "SELECT bid_type_id FROM Deal Where id = ?";
        try {
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $result = $stmt->fetchAllAssociative();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        if (is_array($result))
            return (int)$result[0]['bid_type_id'];
        return 'No results to return';
    }

    /**
     * @param array $ids
     * @param bool $isMarket
     * @return array|bool
     */
    public function fetchUserMarketDealsFromIds(array $ids, $isMarket=true)
    {
        $sql = 'SELECT Deal.id, Deal.issuer_id, Deal.auction_type_id, Deal.asset_type_id, Deal.bid_type_id, Deal.issue, Deal.cut_off_date, Deal.closing_date, ' .
                'Deal.current_balance, Deal.views, Deal.status_id, Deal.user_id, MarketUser.user_name,' .
                'MarketUser.first_name, MarketUser.last_name FROM Deal INNER JOIN MarketUser ON Deal.user_id = MarketUser.id ';
        if ($isMarket){ $sql .= 'WHERE Deal.status_id = 1 AND Deal.id IN (?) ORDER BY Deal.id ASC'; }
        else { $sql .= 'WHERE Deal.status_id IN (1,4) AND Deal.id IN (?) ORDER BY Deal.id ASC'; }
        return $this->fetchByIntArray($this->em, $ids, $sql);
    }

    /**
     * @param int $issuerId
     * @param string $dealName
     * @return array|bool
     */
    public function fetchDealIdByIssuerIdAndDealName(int $issuerId, string $dealName)
    {
        $sql = "SELECT id FROM Deal Where issuer_id = :issuer_id AND issue = :issue";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('issuer_id', $issuerId);
        $stmt->bindValue('issue', $dealName);
        return $this->completeIdFetchQuery($stmt);
    }

    /**
     * @param array $userIds
     * @param array $statusIds
     * @return array|string
     */
    public function findByUserIdsAndStatusIds(array $userIds, array $statusIds)
    {
        $sql = "SELECT id FROM Deal Where user_id IN (?) AND status_id IN (?)";
        try {
            $stmt = $this->em->getConnection()->executeQuery($sql,
                array($userIds, $statusIds),
                array(Connection::PARAM_INT_ARRAY,
                    Connection::PARAM_INT_ARRAY)
            );
            $result = $stmt->fetchAllAssociative();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
        return $this->flattenResultArrayByKey($result, 'id');
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteDealById(int $id)
    {
        $sql = "DELETE FROM Deal WHERE id = $id";
        try {
            $stmt = $this->em->getConnection()->executeQuery($sql);
            $result = $stmt->execute();
        }catch (Exception $exception) {
            return $exception->getMessage();
        }
        return $result;
    }

    /**
     * @param int $dealId
     * @return bool
     */
    public function deleteDealMarketUsersByDealId(int $dealId)
    {
        $sql = "DELETE FROM deal_market_user WHERE deal_id = $dealId";

        try {
            $stmt = $this->em->getConnection()->executeQuery($sql);
            return $stmt->execute();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @return bool|\ReflectionClass
     */
    public function fetchRepositoryClass()
    {
        return $this->entityReflectorFromEntityName('App\Entity\Deal');
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Deal');
    }

    /**
     * @param string|null $subType
     * @return array
     */
    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

    public function fetchAllIssueNames()
    {
        $sql = "SELECT issue from Deal";
        try {
            $stmt = $this->em->getConnection()->executeQuery($sql);
            return $this->flattenResultArrayByKey($stmt->fetchAllAssociative(), 'issue');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function fetchUserDealAccess(int $userId, int $dealId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchUserDealAccessSql,
            self::FETCH_ONE_MTHD,
            [$userId, $dealId]
        );
    }

}
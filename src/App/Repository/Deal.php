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
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Deal extends EntityRepository implements SqlManagerTraitInterface
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

    public function __construct(EntityManager $em, \Doctrine\Common\Persistence\Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    public function fetchDealPoolIdsByDealId(int $id)
    {
        $sql = "SELECT id FROM Pool Where deal_id = :deal_id";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue('deal_id', $id);
        return $this->completeIdFetchQuery($stmt);
    }

    /**
     * @param array $ids
     * @param bool $isMarket
     * @return array|bool
     */
    public function fetchUserMarketDealsFromIds(array $ids, $isMarket=true)
    {
        $sql = 'SELECT Deal.id, Deal.issuer_id, Deal.auction_type_id, Deal.asset_type_id, Deal.bid_type_id, Deal.issue, Deal.cut_off_date, Deal.closing_date, ' .
                'Deal.current_balance, Deal.views, Deal.status_id, Deal.user_id, ' .
                'MarketUser.first_name, MarketUser.last_name FROM Deal INNER JOIN MarketUser ON Deal.user_id = MarketUser.id ';
        if ($isMarket){ $sql .= 'WHERE Deal.status_id = 1 AND Deal.id IN (?) ORDER BY Deal.id ASC'; }
        else { $sql .= 'WHERE Deal.status_id IN (1,4) AND Deal.id IN (?) ORDER BY Deal.id ASC'; }
        $results = $this->fetchByIntArray($this->em, $ids, $sql);
        return $results;
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
     * @return array
     */
    public function findByUserIdsAndStatusIds(array $userIds, array $statusIds)
    {
        $sql = "SELECT id FROM Deal Where user_id IN (?) AND status_id IN (?)";
        $stmt = $this->em->getConnection()->executeQuery($sql,
            array($userIds, $statusIds),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY,
                \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $this->flattenResultArrayByKey($result, 'id');
    }

        /**
     * @param int $id
     * @return bool
     */
    public function deleteDealById(int $id)
    {
        $sql = "DELETE FROM Deal WHERE id = $id";
        $stmt = $this->em->getConnection()->executeQuery($sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @param int $dealId
     * @return bool
     */
    public function deleteDealMarketUsersByDealId(int $dealId)
    {
        $sql = "DELETE FROM deal_market_user WHERE deal_id = $dealId";
        $stmt = $this->em->getConnection()->executeQuery($sql);
        $result = $stmt->execute();
        return $result;
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


}
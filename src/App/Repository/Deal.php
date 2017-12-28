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
      'latest_period_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
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
    ];

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchUserDealsFromIds(array $ids)
    {
        $sql = 'SELECT Deal.id, Deal.issuer_id, Deal.auction_type_id, Deal.asset_type_id, Deal.bid_type_id, Deal.issue, Deal.cut_off_date, Deal.closing_date, ' .
                'Deal.current_balance, Deal.views, ' .
                'MarketUser.first_name, MarketUser.last_name FROM Deal INNER JOIN MarketUser ON Deal.user_id = MarketUser.id ' .
                'WHERE Deal.status_id = 1 AND Deal.id IN (?) ORDER BY Deal.id ASC';
        $results = $this->fetchByIntArray($this->em, $ids, $sql);
        return $results;
    }

    public function fetchDealIdByIssuerIdAndDealName(int $issuerId, string $dealName)
    {
        $sql = "SELECT id FROM Deal Where issuer_id = ? AND issue = ? ";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $issuerId);
        $stmt->bindValue(2, $dealName);
        return $this->completeIdFetchQuery($stmt);
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
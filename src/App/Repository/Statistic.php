<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/10/17
 * Time: 10:04 AM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class Statistic extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'deal_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'states' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_states' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'ltv' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_ltv' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'balance' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_balance' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'rate' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_rate' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'loan_type' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'property_type' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'occupancy' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'maturity' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_maturity' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'credit' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'summary_credit' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL'],
      'filter_data' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NOT NULL']
    ];

    /**
     * @param array $dealIds
     * @param bool $mapStatisticsToDeal
     * @return array|bool
     */
    public function fetchDealStatisticsByDealIds(array $dealIds, $mapStatisticsToDeal = true)
    {
        $sql = 'SELECT * FROM Statistic WHERE deal_id IN (?)';
        $results = $this->fetchByIntArray($this->em, $dealIds, $sql);
        if(count($results) > 0 && $mapStatisticsToDeal){
            $results = $this->mapRequestIdsToResults($dealIds, $results, "deal_id");
        }
        return $results;
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Statistic');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

}
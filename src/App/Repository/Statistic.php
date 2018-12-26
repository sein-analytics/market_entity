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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class Statistic extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'deal_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'states' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_states' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'ltv' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_ltv' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'balance' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_balance' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'rate' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_rate' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'loan_type' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'property_type' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'occupancy' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'maturity' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_maturity' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'credit' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'summary_credit' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
      'filter_data' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL']
    ];

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

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
     * @param int $dealId
     * @return array|bool
     */
    public function fetchStatisticIdByDealId(int $dealId)
    {
        $sql = "SELECT id FROM Statistic Where deal_id = ?";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $dealId);
        return $this->completeIdFetchQuery($stmt);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteStatisticById(int $id)
    {
        $sql = "DELETE FROM Statistic WHERE id = $id";
        $stmt = $this->em->getConnection()->executeQuery($sql);
        $result = $stmt->execute();
        return $result;
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
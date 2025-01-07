<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/10/17
 * Time: 10:04 AM
 */

namespace App\Repository;


use App\Repository\Statistic\StatisticInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class Statistic extends EntityRepository
    implements SqlManagerTraitInterface, StatisticInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        self::STATS_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::STATS_DEAL_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::STATS_STATES_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_STATES_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_LTV_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_LTV_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_BAL_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_BAL_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_RATE_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_RATE_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_LOAN_TYPE_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_PROP_TYPE_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_OCCU_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_MAT_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_MAT_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_CREDIT_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::SUMRY_CREDIT_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        self::STATS_FILTER_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL']
    ];

    private string $deleteStatisticByIdSql = "DELETE FROM Statistic WHERE id=?";

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
    public function fetchDealStatisticsByDealIds(array $dealIds, bool $mapStatisticsToDeal=true)
    {
        $results = $this->fetchByIntArray($this->em, $dealIds, self::SELECT_ALL_BY_DEAL_SQL);
        if(is_array($results)
            &&count($results) > 0
            && $mapStatisticsToDeal){
            return $this->mapRequestIdsToResults($dealIds, $results, self::STATS_DEAL_ID_KEY);
        }
        return [];
    }

    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchStatisticIdByDealId(int $dealId)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::SELECT_ID_BY_DEAL_SQL,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );

        return $this->completeIdFetchQuery($results);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteStatisticById(int $id)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteStatisticByIdSql,
            self::EXECUTE_MTHD,
            [$id]
        );
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId(self::STATS_TABLE_NAME);
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

}
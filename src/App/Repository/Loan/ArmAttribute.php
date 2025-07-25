<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 10:51 AM
 */

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;

class ArmAttribute extends EntityRepository 
    implements SqlManagerTraitInterface, DbalStatementInterface, LoanInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'gross_margin' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'minimum_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'maximum_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'rate_index' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'fst_rate_adj_period' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'fst_rate_adj_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'fst_pmnt_adj_period' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'fst_pmnt_adj_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'rate_adj_frequency' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'periodic_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'initial_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'pmnt_adj_frequency' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'pmnt_increase_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
      'arm_expiration_date' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ARM_ATTR_CATEGORY],
    ];

    private $deleteArmAttributesByIdsSql = "DELETE FROM ArmAttribute WHERE id IN (?)";

    private $fetchArmAttributeIdsByLoanIdsSql = "SELECT id FROM ArmAttribute Where loan_id in (?)";

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteArmAttributesByIds(array $ids)
    {
        return $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->deleteArmAttributesByIdsSql,
            self::EXECUTE_MTHD,
            $ids
        );

        return $result;
    }

    /**
     * @param array $loanIds
     * @return array|bool
     */
    public function fetchArmAttributeIdsByLoanIds(array $loanIds)
    {
        $results = $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->fetchArmAttributeIdsByLoanIdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            $loanIds
        );

        if (count($results) > 0) {
            $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID);
        } else {
            $results = false;
        }

        return $results;
    }

    
    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('ArmAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
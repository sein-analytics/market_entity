<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 10:51 AM
 */

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class ArmAttribute extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'gross_margin' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'minimum_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'maximum_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'rate_index' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'fst_rate_adj_period' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
      'fst_rate_adj_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
      'fst_pmnt_adj_period' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
      'fst_pmnt_adj_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
      'rate_adj_frequency' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'periodic_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'initial_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'pmnt_adj_frequency' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
      'pmnt_increase_cap' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL']
    ];

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteArmAttributesByIds(array $ids)
    {
        $sql = 'DELETE FROM ArmAttribute WHERE id IN (?)';
        $stmt = $this->returnInArraySqlStmt($this->em, $ids, $sql);
        $result = $stmt->execute();
        return $result;
    }

    public function fetchArmAttributeIdsByLoanIds(array $loanIds)
    {
        $sql = "SELECT id FROM ArmAttribut Where loan_id in (?)";
        $stmt = $this->returnInArraySqlStmt($this->em, $loanIds, $sql);
        return $this->completeIdFetchQuery($stmt);
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
        array_keys(self::$table);
    }
}
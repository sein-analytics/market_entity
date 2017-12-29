<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 10:07 AM
 */

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Pool extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;
    
    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'deal_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'bonds_count' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'bonds_total_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'loan_total_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'loans_count' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'original_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'pool_structure' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
      'is_crossed' => [self::DATA_TYPE => 'tinyint', self::DATA_DEFAULT => false],
      'is_pogroup' => [self::DATA_TYPE => 'tinyint', self::DATA_DEFAULT => 'NULL'],
      'is_io_group' => [self::DATA_TYPE => 'tinyint', self::DATA_DEFAULT => 'NULL'],
      'add_reserve_to_credit_support' => [self::DATA_TYPE => 'tinyint', self::DATA_DEFAULT => 'NULL']
    ];

    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchPoolIdsByDealId(int $dealId)
    {
        $sql = "SELECT id FROM Pool Where deal_id = ?";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $dealId);
        return $this->completeIdFetchQuery($stmt);
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deletePoolByIds(array $ids)
    {
        $sql = 'DELETE FROM Pool WHERE id IN (?)';
        $stmt = $this->returnInArraySqlStmt($this->em, $ids, $sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Pool');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 11:10 AM
 */

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class DealFile extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'deal_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'user_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
      'mime_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'doc_type_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'file_name' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'file_size' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'local_path' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
      'virus_scan_id' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'scan_location' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'has_viruses' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL']
    ];

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteDealFileByIds(array $ids)
    {
        $sql = "DELETE FROM DealFile WHERE id IN (?)";
        $stmt = $this->returnInArraySqlStmt($this->em, $ids, $sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('DealFile');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
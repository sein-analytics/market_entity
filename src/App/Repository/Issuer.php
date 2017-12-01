<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 2:14 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class Issuer extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;
    
    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'issuer_name' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'approved_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
      'equity' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'outstanding' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'main_contact' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'phone' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL']
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Issuer');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        array_keys(self::$table);
    }
}
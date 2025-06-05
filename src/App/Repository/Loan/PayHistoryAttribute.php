<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;


class PayHistoryAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'history1' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history2' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history3' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history4' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history5' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history6' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history7' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history8' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history9' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history10' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history11' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'history12' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('PayHistoryAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
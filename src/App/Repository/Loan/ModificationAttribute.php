<?php

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;

class ModificationAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'modification_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        'capitalized_amount' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'modification_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'post_mod_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('ModificationAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
<?php

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityRepository;

class MortgagePaymentCode extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    private string $delimiter = '/';

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'code' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'slugs' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
    ];

    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('MortgagePaymentCode');
    }

    function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
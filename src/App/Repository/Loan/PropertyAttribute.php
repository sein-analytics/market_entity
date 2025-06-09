<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class PropertyAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'address' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'report_links' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL'],
        'price_comps' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL'],
        'property_pictures' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL'],
        'property_links' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL'],
        'seller_as_is_value' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('PropertyAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
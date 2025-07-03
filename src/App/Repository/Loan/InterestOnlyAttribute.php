<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class InterestOnlyAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'interest_only_term' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'interest_only_indicator' => [self::DATA_TYPE => 'string', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'interest_only_payment' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'interest_only_start_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
        'interest_only_expiration_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::IO_ATTR_CATEGORY],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('InterestOnlyAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
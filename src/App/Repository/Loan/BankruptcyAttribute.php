<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class BankruptcyAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{

    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'delinquent_attribute_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'file_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'case_number' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'dismissed_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'plan_start_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'plan_end_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'post_petition_due_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'case_closed_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
        'motion_relief_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::BK_ATTR_CATEGORY],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('BankruptcyAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class ForeclosureAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{

    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'delinquent_attribute_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'foreclosure_start_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'foreclosure_bid_amount' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'actual_sale_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'judgement_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'referred_to_atty_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'service_complete_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'foreclosure_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'schedule_sale_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'completed_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'removal_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'suspended_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'foreclosure_type' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'next_step_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
        'referral_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::FORCS_ATTR_CATEGORY],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('ForeclosureAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
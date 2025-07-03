<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class DelinquentAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'sub_servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'servicer_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'sub_servicer_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'sub_servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'master_servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'master_servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'asset_manager' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'asset_manager_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'asset_manager_sub_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'days_delinquent' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'delinquent_principal' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'delinquent_interest' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'total_delinquent_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'general_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'sub_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'sub_status_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'suspense_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'deferred_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
        'accrued_interest' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::DQ_ATTR_CATEGORY],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('DelinquentAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
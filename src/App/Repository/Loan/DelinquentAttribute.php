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
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'modification_attribute' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'foreclosure_attribute' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'bankruptcy_attribute' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'loss_mitigation_attribute' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'escrow_attribute' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'sub_servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'servicer_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'sub_servicer_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'sub_servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'master_servicer' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'master_servicer_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'asset_manager' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'asset_manager_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'asset_manager_sub_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'days_delinquent' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'delinquent_principal' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'delinquent_interest' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'total_delinquent_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'general_notes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
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
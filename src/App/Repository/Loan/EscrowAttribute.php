<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class EscrowAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'delinquent_attribute_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'total_debt_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'accrued_late_fees' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'escrow_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'restricted_escrow' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'escrow_advance_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'corp_advance_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'third_party_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'accrued_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'tax_and_insurance_payment' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
        'total_piti' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL'],
    ];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('EscrowAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
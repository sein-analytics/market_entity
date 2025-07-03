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
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'delinquent_attribute_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'total_debt_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'accrued_late_fees' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'escrow_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'restricted_escrow' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'escrow_advance_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'corp_advance_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'third_party_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'accrued_balance' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'tax_and_insurance_payment' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
        'total_piti' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::ESCROW_ATTR_CATEGORY],
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
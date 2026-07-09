<?php

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class EscrowAttribute extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, LoanInterface
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

    private $fetchAttributesByDealIdSql = "SELECT escrwAttr.* FROM EscrowAttribute AS escrwAttr INNER JOIN loans AS l ON l.id = escrwAttr.loan_id INNER JOIN Pool AS p ON p.id = l.pool_id WHERE p.deal_id=?";

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('EscrowAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

    public function fetchAttributesByDealId(int $dealId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAttributesByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }
}
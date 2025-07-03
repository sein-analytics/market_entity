<?php


namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class SaleAttribute extends EntityRepository 
    implements SqlManagerTraitInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::SALE_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::SALE_CATEGORY],
        'availability' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 1.0, self::PROP_CATEGORY_KEY =>self::SALE_CATEGORY],
    ];

    private string $fetchSaleAttributeIdsByLoanIdsSql = "SELECT id FROM SaleAttribute Where loan_id in (?)";

    public function fetchSaleAttributeIdsByLoanIds(array $loanIds)
    {
        $results = $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->fetchSaleAttributeIdsByLoanIdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            $loanIds
        );

        if (count($results) > 0) {
            $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID);
        } else {
            $results = false;
        }

        return $results;
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        array_keys(self::$table);
    }

}
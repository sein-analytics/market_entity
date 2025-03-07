<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 2018-12-20
 * Time: 13:19
 */

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
class CommAttribute extends EntityRepository 
    implements SqlManagerTraitInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'dscr' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'noi' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'net_worth_to_loan' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'profit_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'loan_to_cost_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'debt_yield_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'vacancy_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'lockout_period' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'defeasance_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        'cap_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL']
    ];

    private string $fetchCommAttributeIdsByLoanIdsSql = "SELECT id FROM CommAttribute Where loan_id in (?)";

    public function fetchCommAttributeIdsByLoanIds(array $loanIds)
    {
        $results = $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->fetchCommAttributeIdsByLoanIdsSql,
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

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('CommAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        array_keys(self::$table);
    }
}
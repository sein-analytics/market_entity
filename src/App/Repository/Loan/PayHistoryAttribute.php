<?php

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;


class PayHistoryAttribute extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, LoanInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history1' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history2' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history3' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history4' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history5' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history6' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history7' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history8' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history9' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history10' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history11' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history12' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history13' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history14' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history15' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history16' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history17' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
        'history18' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PAY_HIST_CATEGORY],
    ];

    private string $fetchPayHistoryByIdSql = "SELECT * FROM PayHistoryAttribute WHERE id=?";

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('PayHistoryAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

    public function fetchPayHistoryById(int $id)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchPayHistoryByIdSql,
            self::FETCH_ASSO_MTHD,
            [$id]
        );
    }

}
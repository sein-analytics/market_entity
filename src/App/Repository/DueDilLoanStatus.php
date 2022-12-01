<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/10/18
 * Time: 3:12 PM
 */

namespace App\Repository;


use App\Repository\DueDiligence\DueDiligenceAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use function Lambdish\phunctional\{each};
use function PHPUnit\TestFixture\func;

class DueDilLoanStatus extends DueDiligenceAbstract
{
    use FetchMapperTrait, FetchingTrait;

    private array $tableProps = [
        self::DDLS_QRY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
        self::DDLS_QRY_DD_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DUE_DIL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DDLS_QRY_LOAN_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::LOAN_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DDLS_QRY_STATUS_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DD_REVIEW_STATUS_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DDLS_QRY_LOGGER_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
    ];

    private string $insertDueDilLoanStatusSql = "INSERT INTO DueDilLoanStatus VALUE (null, ?, ?, ?, ?)";

    private string $updateLoggerSql = "UPDATE DueDilLoanStatus SET logger=? WHERE id=?";

    private string $updateStatusCodeSql = "UPDATE DueDilLoanStatus SET status_id=? WHERE id=?";

    public function insertNewDueDilLoanStatus (array $params):mixed
    {
        if (array_key_exists(self::DDLS_QRY_ID_KEY , $params))
            unset($params[self::DDLS_QRY_ID_KEY ]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertDueDilLoanStatusSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateLoggerByStatusId(int $id, array $logger):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateLoggerSql,
            self::EXECUTE_MTHD,
            [$logger, $id]
        );
    }

    public function updateStatusCodeByStatusId(int $id, int $codeId):mixed
    {
        if (!in_array($codeId, self::DD_LN_STATUS_ARRAY))
            return false;
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateStatusCodeSql,
            self::EXECUTE_MTHD,
            [$codeId, $id]
        );
    }

    public function fetchLoanIdsByDdId(int $ddId)
    {
        $sql = 'SELECT ln_id AS id, loan_id, ddStat.status_id, dd_id, user_id, dd_role_id, first_name, last_name, status FROM DueDilLoanStatus ddStat ' .
            'LEFT JOIN loans ln ON ln.id = ddStat.ln_id ' .
            'LEFT JOIN DueDiligence dd ON dd.id=dd_id ' .
            'LEFT JOIN MarketUser users ON users.id=user_id ' .
            'LEFT JOIN DueDilReviewStatus revStat on revStat.id=ddStat.status_id ' .
            'WHERE dd_id = ? ORDER BY id ASC';
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $ddId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $results;
    }

    public function returnBaseInsertArray (): array
    {
        $base = [];
        each(function ($props, $key) use(&$base) {
            if ($props[self::TBL_PROP_DEFAULT_KEY] === self::TBL_PROP_NONE_DEFAULT)
                $base[$key] = null;
            else
                $base[$key] = $props[self::TBL_PROP_DEFAULT_KEY];
        }, $this->returnTablePropsArray());
        return $base;
    }

    public function returnTablePropsArray (): array {
        $base = $this->tableProps;
        $base[self::DDLS_QRY_LOGGER_KEY][self::TBL_PROP_DEFAULT_KEY] = [json_encode(self::BASE_LOGGER_ARRAY)];
        return $base;
    }
}
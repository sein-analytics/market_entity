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

    private string $insertDueDilLoanStatusSql = "INSERT INTO DueDilLoanStatus (`dd_id`, `ln_id`, `status_id`, `logger`, `issues_count`, `last_modified`) VALUES (?,?,?,?,?,?)";

    private string $updateLoggerSql = "UPDATE DueDilLoanStatus SET logger=? WHERE id=?";

    private string $updateStatusCodeSql = "UPDATE DueDilLoanStatus SET status_id=? WHERE id=?";

    private string $updateStatusCodeByLoanAndDdId = "UPDATE DueDilLoanStatus SET status_id=?, issues_count=?, last_modified=?, logger=? WHERE ln_id=? AND dd_id=?";

    private string $updateLastModifiedByLoanAndDdId = "UPDATE DueDilLoanStatus SET last_modified=? WHERE ln_id=? AND dd_id=?";

    private string $deleteStatusByDdIdLoanIdSql = "DELETE FROM DueDilLoanStatus WHERE dd_id=? AND ln_id=?";

    private string $multipleInsertsDdLoanStatus = "INSERT INTO DueDilLoanStatus (`dd_id`, `ln_id`, `status_id`, `logger`, `issues_count`, `last_modified`) VALUES";

    private string $fetchStatusesByDdsAndLoanSql = "SELECT * FROM DueDilLoanStatus WHERE dd_id IN (?) AND ln_id IN (?)";

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
            [json_encode($logger), $id]
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

    public function setStatusCodeByLoanAndDdId(int $loanId, int $dueDiligenceId, int $codeId, int $issuesCount, ?string $date, string $logger):mixed
    {
        if (!in_array($codeId, self::DD_LN_STATUS_ARRAY))
            return false;
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateStatusCodeByLoanAndDdId,
            self::EXECUTE_MTHD,
            [$codeId, $issuesCount, $date, $logger, $loanId, $dueDiligenceId]
        );
    }

    public function setLastModifiedByLoanAndDdId(int $loanId, int $dueDiligenceId, string $date):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateLastModifiedByLoanAndDdId,
            self::EXECUTE_MTHD,
            [$date, $loanId, $dueDiligenceId]
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

        return  $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::FETCH_ALL_ASSO_MTHD,
            [$ddId]
        );
    }

    public function deleteDdLoanStatusByDdIdLoanId(int $ddId, int $lnId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteStatusByDdIdLoanIdSql,
            self::EXECUTE_MTHD,
            [$ddId, $lnId]
        );
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

    public function ddLoanStatusApiMapper ():array
    {
        return [
            self::DDLS_QRY_DD_ID_KEY => self::API_DUE_DIL_ID_KEY,
            self::DDLS_QRY_LOAN_ID_KEY => self::API_LOAN_ID_KEY,
            self::DDLS_QRY_LOGGER_KEY => self::API_LOGGER_KEY
        ];
    }

    public function updateLoggerApiIssueId (array $apiLogger, int $issueId):array
    {
        foreach ($apiLogger[self::API_FILE_UPDATE_LOAN_KEY][self::API_LOGGER_KEY][0][self::API_FILES_KEY][$apiLogger[self::API_FILE_UPDATE_FILE_KEY][self::API_DD_FILE_ID_KEY]] as $key => $annotArr){
            if ($annotArr[self::API_ANNOTATION_ID_KEY] === $apiLogger[self::API_LOGGER_ACTION_DATA_KEY][self::API_ANNOTATION_ID_KEY]){
                $apiLogger[self::API_FILE_UPDATE_LOAN_KEY][self::API_LOGGER_KEY][0][self::API_FILES_KEY][$apiLogger[self::API_FILE_UPDATE_FILE_KEY][self::API_DD_FILE_ID_KEY]][$key][self::API_DD_ISSUE_ID_KEY] = $issueId;
                break;
            }
        }
        return $apiLogger;
    }

    public function createInsertParams(int $dueDiligenceId, int $loanId):array {
        return [
            self::DDLS_QRY_DD_ID_KEY => $dueDiligenceId,
            self::DDLS_QRY_LOAN_ID_KEY => $loanId,
            self::DDLS_QRY_STATUS_ID_KEY => self::DD_LN_OPEN,
            self::DDLS_QRY_LOGGER_KEY => $this->baseDdLogger(),
            self::DDLS_QRY_ISSUES_COUNT_KEY => self::DDLS_BASE_ISSUES_COUNT,
            self::DDLS_QRY_LAST_MODIFIED_KEY => null,
        ];
    }

    public function addMultiDdLoanStatusInputs(int $loanId, array $dueDiligencesIds)
    {
        $base = $this->multipleInsertsDdLoanStatus;
        $nullValue = "NULL";
        $ddInsertCount = 0;
        foreach ($dueDiligencesIds as $ddId) {
            $ddInsertCount++;
            $base = $base . PHP_EOL .
            '(' .
                $ddId . ',' . $loanId . ',' .
                self::DD_LN_OPEN . ',"' . 
                $this->baseDdLogger() .
            '",' . 0 . ", $nullValue" . ')' . ($ddInsertCount == count($dueDiligencesIds) ? ';' : ','); 
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }

    public function baseDdLogger()
    {
        $baseLogger = self::BASE_LOGGER_ARRAY;
        return json_encode([$baseLogger]);
    }

    public function fetchDueDilLoanStatusByDdAndLn(int $ddId, int $lnId)
    {
        $baseQry = "SELECT ddLnStatus.dd_id AS ddId, ddLnStatus.ln_id AS loanId, ddLnStatus.status_id AS statusId, " . 
            "ddLnStatus.issues_count AS issuesCount, ddLnStatus.last_modified AS lastModified, ddLnStatus.logger, " .
            "dds.parent_id AS ddParentId, dds.deal_id AS dealId, dds.user_id AS userId, user.issuer_id AS issuerId " .
            "FROM DueDilLoanStatus AS ddLnStatus " .
            "LEFT JOIN DueDiligence AS dds ON dds.id = ddLnStatus.dd_id " .
            "LEFT JOIN MarketUser AS user ON user.id = dds.user_id " .
            "WHERE ddLnStatus.dd_id=? AND ddLnStatus.ln_id=?";

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $baseQry,
            self::FETCH_ASSO_MTHD,
            [$ddId, $lnId]
        );
    }

    public function fetchParentAndChildDdLnSByFileAndLoan(int $ddParentId, int $fileId, int $loanId)
    {
        $sql = "SELECT ddlns.*, dds.parent_id, dds.deal_id AS dealId, ddUser.issuer_id AS issuerId FROM DueDilLoanStatus AS ddlns ".
            "LEFT JOIN ( ".
                "SELECT id, parent_id, user_id, deal_id FROM DueDiligence WHERE id = $ddParentId UNION ALL ".
                "SELECT id, parent_id, user_id, deal_id FROM DueDiligence WHERE parent_id = $ddParentId ".
            ") AS dds ON ddlns.dd_id = dds.id ".
            "LEFT JOIN MarketUser AS ddUser ON ddUser.id = dds.user_id " .
            "LEFT JOIN deal_file_due_diligence AS dfDd ".
            "ON dfDd.due_diligence_id = dds.id AND dfDd.deal_file_id = $fileId ".
            "WHERE ddlns.ln_id = $loanId AND dfDd.due_diligence_id IS NOT NULL";

            return $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $sql,
                self::FETCH_ALL_ASSO_MTHD
            );
    }

    public function setStatusFileAction(int $id, string $date, array $logger, ?int $issuesCount = null)
    {
        $logger = json_encode($logger);
        $sql = "UPDATE DueDilLoanStatus SET last_modified=?, logger=?";
        $params = [$date, $logger];

        if (!is_null($issuesCount)) {
            $sql = $sql . ", issues_count=?";

            $params[] = $issuesCount;
        }

        $params[] = $id;

        $sql = $sql." WHERE id=?";

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            $params
        );
    }

    public function updateParentAndChildStatusByDdAndLoan(int $ddParentId, int $loanId, int $statusId)
    {
        $sql = "UPDATE DueDilLoanStatus AS ddlns ".
            "JOIN DueDiligence AS dds ON ddlns.dd_id = dds.id ".
            "SET ddlns.status_id=? ".
            "WHERE ddlns.ln_id=? ".
            "AND (dds.id=? OR dds.parent_id=?)";

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            [$statusId, $loanId, $ddParentId, $ddParentId]
        );
    }

    public function fetchStatusesByDdsAndLoan(array $dueDiligenceIds, int $loanId):mixed
    {
        $sql = "SELECT ddlns.*, dds.parent_id FROM DueDilLoanStatus AS ddlns ".
            "LEFT JOIN DueDiligence AS dds ON dds.id = ddlns.dd_id ".
            "WHERE dd_id IN (?) AND ln_id IN (?)";

        try {
            return $this->buildAndExecuteMultiIntStmt(
                $this->getEntityManager(),
                $sql,
                self::FETCH_ALL_ASSO_MTHD,
                $dueDiligenceIds, [$loanId]
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
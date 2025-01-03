<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/10/18
 * Time: 3:06 PM
 */

namespace App\Repository;


use App\Repository\DueDiligence\DueDiligenceAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use function Lambdish\phunctional\{each};

class DueDiligenceIssue extends DueDiligenceAbstract
{
    use FetchingTrait, FetchMapperTrait;

    private array $tableProps = [
        self::ISS_QRY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>null],
        self::QRY_DD_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DUE_DIL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::QRY_STATUS_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DD_ISSUE_STATUS_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::ISSUE_OPEN_STATUS],
        self::QRY_FILE_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DEAL_FILE_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::QRY_PRIORITY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::MSG_PRIORITY_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::NORMAL_ISSUE],
        self::QRY_LOAN_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::LOAN_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::QRY_ISS_TEXT => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>null],
        self::QRY_NOTIFY_SELLER_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>false],
        self::QRY_NOTIFY_TEAM_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>false],
        self::QRY_OPEN_DATE_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::QRY_CLOSE_DATE_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::QRY_ANNO_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
    ];

    private string $insertIssueSql = "INSERT INTO DueDiligenceIssue VALUE (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $closeIssueSql = "UPDATE DueDiligenceIssue SET status_id=?, closed_date=? WHERE id=?";

    private string $issueIdByAnnotIdSql = "SELECT id FROM DueDiligenceIssue WHERE annotation_id=?";

    private string $updateIssueStringSql = "UPDATE DueDiligenceIssue SET issue=? WHERE id=?";

    private string $updateIssueStatusSql = "UPDATE DueDiligenceIssue SET status_id=? WHERE id=?";

    public function insertNewDueDiligenceIssue(array $params): mixed
    {
        if (array_key_exists(self::ISS_QRY_ID_KEY, $params))
            unset($params[self::ISS_QRY_ID_KEY]);
        $params = $this->insertBoolToInt($params);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertIssueSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    protected function insertBoolToInt (array $params):array
    {
        if ($params[self::QRY_NOTIFY_SELLER_KEY] === true)
            $params[self::QRY_NOTIFY_SELLER_KEY] = 1;
        else
            $params[self::QRY_NOTIFY_SELLER_KEY] = 0;
        if ($params[self::QRY_NOTIFY_TEAM_KEY] === true)
            $params[self::QRY_NOTIFY_TEAM_KEY] = 1;
        else
            $params[self::QRY_NOTIFY_TEAM_KEY] = 0;
        return $params;
    }

    public function updateDueDiligenceIssueText (int $issueId, string $text):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateIssueStringSql,
            self::EXECUTE_MTHD,
            [$text, $issueId]
        );
    }

    public function closeDueDiligenceIssue (array $params):mixed
    {
        $hasAllProps = true;
        each(function ($val, $key) use ($params, &$hasAllProps){
            if (!array_key_exists($key, $params))
                $hasAllProps = false;
        }, $this->returnCloseIssuePropsArray());
        if ($hasAllProps){
            return $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->closeIssueSql,
                self::EXECUTE_MTHD,
                array_values($params)
            );
        }
        return false;
    }

    public function updateIssueStatus(int $status, int  $id):bool
    {
        try {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->updateIssueStatusSql,
                self::EXECUTE_MTHD,
                [$status, $id]
            );
        } catch (\Exception $e){
            return false;
        }

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function fetchIssueIdByAnnotationId(string $annotId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->issueIdByAnnotIdSql,
            self::FETCH_ONE_MTHD,
            [$annotId]
        );
    }

    public function returnRandomUUid ():string {
        return Str::uuid()->getHex()->toString();
    }

    public function returnBaseInsertArray (): array
    {
       $base = [];
       each(function($props, $key) use(&$base) {
           if ($key === self::QRY_CLOSE_DATE_KEY)
               $base[$key] = self::DEFAULT_START_DATE;
           elseif($key === self::QRY_OPEN_DATE_KEY)
               $base[$key] = date("Y-m-d H:i:s");
           elseif($key === self::ISS_QRY_ID_KEY)
               $base[$key] = 0;
           elseif($key === self::QRY_ANNO_ID_KEY)
               $base[$key] = $this->returnRandomUUid();
           else
               $base[$key] = $props[self::TBL_PROP_DEFAULT_KEY];
       }, $this->tableProps);
       return $base;
    }

    public function dueDilIssueApiMapper():array
    {
        return [
            self::QRY_DD_ID_KEY => self::API_DUE_DIL_ID_KEY,
            self::QRY_FILE_ID_KEY => self::API_DD_FILE_ID_KEY,
            self::QRY_LOAN_ID_KEY => self::API_LOAN_ID_KEY,
            self::QRY_ISS_TEXT => self::API_ANNOTATION_NOTE_KEY,
            self::QRY_NOTIFY_SELLER_KEY => self::API_ANNOT_NOTIFY_SELLER_KEY,
            self::QRY_NOTIFY_TEAM_KEY => self::API_ANNOT_NOTIFY_TEAM_KEY,
            self::QRY_ANNO_ID_KEY => self::API_ANNOTATION_ID_KEY
        ];
    }

    public function returnTablePropsArray (): array { return $this->tableProps; }

    public function returnCloseIssuePropsArray ():array
    {
        return [
            self::ISS_QRY_ID_KEY => null,
            self::QRY_CLOSE_DATE_KEY => date("Y-m-d H:i:s"),
            self::QRY_STATUS_ID_KEY => self::ISSUE_CLOSED_STATUS
        ];
    }
}
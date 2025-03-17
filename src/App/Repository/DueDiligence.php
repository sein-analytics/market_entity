<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/9/18
 * Time: 3:00 PM
 */

namespace App\Repository;


use App\Repository\DueDiligence\DueDiligenceAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\ORM\Query;
use function Lambdish\phunctional\{each};

class DueDiligence extends DueDiligenceAbstract
{
    use FetchMapperTrait, FetchingTrait;

    private array $tableProps = [
        self::DD_QRY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
        self::DD_QRY_USER_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::MKT_USER_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DD_QRY_DEAL_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DEAL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DD_QRY_ROLE_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DD_ROLE_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::MEMBER_ROLE],
        self::DD_QRY_STATUS_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DD_STATUS_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::DD_OPEN_STATUS],
        self::DD_QRY_BID_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::BID_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY => null],
        self::DD_QRY_PARENT_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::DUE_DIL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY => null],
    ];

    private string $insertDueDilSql = "INSERT INTO DueDiligence VALUE (null, ?, ?, ?, ?, ?, ?)";

    private string $insertDdFileSql = "INSERT INTO deal_file_due_diligence VALUE (?, ?)";

    private string $updateFileDdIdByDdIdFileIdSql = "UPDATE deal_file_due_diligence SET due_diligence_id=? WHERE due_diligence_id=? AND deal_file_id=?";

    private string $teamMemberDdIdSql = "SELECT id FROM DueDiligence WHERE deal_id=? AND user_id=? AND parent_id=?;";

    private string $teamMemberDdsSql = "SELECT id, user_id, bid_id, parent_id FROM DueDiligence WHERE deal_id=? AND user_id=? AND parent_id=? OR id=?;";

    private string $manyToManyFileIdSql = "SELECT deal_file_id FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    private string $deleteFromManyToManySql = "DELETE FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    private string $leadDdIdsUserIdsByDealIdSql = "SELECT dueDil.id, dueDil.user_id, dueDil.bid_id, CONCAT(mktUsers.first_name,' ', mktUsers.last_name) AS ddUserName, Issuer.id AS ddUserIssuerId, Issuer.issuer_name AS buyersCompany FROM `DueDiligence` dueDil LEFT JOIN MarketUser mktUsers ON mktUsers.id = dueDil.user_id LEFT JOIN Issuer on Issuer.id = mktUsers.issuer_id WHERE dd_role_id=1 AND deal_id=?;";

    private string $ddLeadsByDealIdLoanIdSql = "SELECT dueDil.id, dueDil.user_id, dueDil.bid_id, CONCAT(mktUsers.first_name,' ', mktUsers.last_name) AS ddUserName, Issuer.id AS ddUserIssuerId, Issuer.issuer_name AS buyersCompany FROM `DueDiligence` dueDil LEFT JOIN MarketUser mktUsers ON mktUsers.id = dueDil.user_id LEFT JOIN Issuer on Issuer.id = mktUsers.issuer_id WHERE dd_role_id=1 AND deal_id=? and dueDil.id IN(SELECT dd_id FROM DueDilLoanStatus WHERE ln_id = ?)";

    private string $allDdUserFileAccessSql = "SELECT dueDil.id, dueDil.user_id, CONCAT(mktUsers.first_name,' ', mktUsers.last_name) AS ddUserName, Issuer.id AS ddUserIssuerId, Issuer.issuer_name AS buyersCompany FROM DueDiligence dueDil LEFT JOIN MarketUser mktUsers ON mktUsers.id = dueDil.user_id LEFT JOIN Issuer on Issuer.id = mktUsers.issuer_id WHERE dueDil.id IN (SELECT due_diligence_id FROM deal_file_due_diligence WHERE deal_file_id=?)";

    private string $dueDilIdsUserIdsByDealIdSql = "SELECT id, user_id FROM `DueDiligence` WHERE deal_id=?;";

    private string $userDueDiligenceIdsSql = "SELECT id FROM `DueDiligence` WHERE user_id=?";

    private string $multipleInsertsDealFileDd = "INSERT INTO deal_file_due_diligence (`due_diligence_id`, `deal_file_id`) VALUES";

    private string $selectDealFileDueDiligenceByDdsAndFileId  = "SELECT due_diligence_id FROM deal_file_due_diligence WHERE due_diligence_id IN (?) AND deal_file_id=?";

    private string $fetchDdIdsByUserIdsDealIdsSql = "SELECT id FROM DueDiligence WHERE `user_id` IN (?) AND deal_id IN (?) AND id NOT IN (?)";

    private string $fetchDueDiligenceByIdSql = "SELECT * FROM DueDiligence WHERE id=?";

    private string $fetchDueDiligenceByParentAndUserSql = "SELECT * FROM DueDiligence WHERE parent_id=? AND user_id=?";

    private string $fetchOneDfDdByDdAndLoanSql = "SELECT dfdd.* FROM deal_file_due_diligence AS dfdd JOIN DealFile AS df ON dfdd.deal_file_id=df.id WHERE dfdd.due_diligence_id=? AND df.loan_id=? LIMIT 1";

    public function insertNewDueDiligence(array $params):mixed
    {
        if (array_key_exists(self::DD_QRY_ID_KEY, $params))
            unset($params[self::DD_QRY_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertDueDilSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function insertNewDealFileDueDiligence (array $params):mixed
    {
        $hasParams = true;
        each(function ($nullVal, $key) use(&$hasParams, $params){
            if (!array_key_exists($key, $params))
                $hasParams = false;
        }, $this->returnDealFileDdManyToManyProps());
        if ($hasParams)
            return $this->buildAndExecuteFromSql(
                    $this->getEntityManager(),
                    $this->insertDdFileSql,
                    self::EXECUTE_MTHD,
                    array_values($params)
                );
        return false;
    }

    public function fetchFileIdByDdIdFileId (int $dueDilId, $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->manyToManyFileIdSql,
            self::EXECUTE_MTHD,
            [$dueDilId, $fileId]
        );
    }

    public function deleteFromDealFileDueDiligence(int $ddId, int $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteFromManyToManySql,
            self::EXECUTE_MTHD,
            [$ddId, $fileId]
        );
    }

    public function reassignDdIdByDdIdDealFileId (int $ddId, int $fileId, int $newDdId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateFileDdIdByDdIdFileIdSql,
            self::EXECUTE_MTHD,
            [$newDdId, $ddId, $fileId]
        );
    }

    public function fetchDueDilBuyersLoanData(array $ids)
    {
        return $this->executeProcedure([implode(', ', $ids)], self::$callDueDilBuyersLoanData);
    }

    public function fetchDueDilSellersLoanData(array $ids)
    {
        return $this->executeProcedure([implode(', ', $ids)], self::$callDueDilSellersLoanData);
    }

    public function fetchDueDilSellerBiddersData(array $dealIds)
    {
        return $this->executeProcedure([implode(', ', $dealIds)], self::$callDueDilSellerBiddersData);
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserSaleDealIdsInDueDiligence (int $userId):mixed
    {
        return $this->executeProcedure([$userId], self::$callUserSaleDealIdsInDueDiligence);
    }

    public function fetchTeamFileOwnerId (int $dealId, int $fileId, int $parentId)
    {
        return $this->executeProcedure([$dealId, $fileId, $parentId], self::$callDiligenceTeamFileOwner);
    }

    public function fetchTeamMemberDueDiligenceIdForDeal (int $dealId, int $userId, int $parentId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->teamMemberDdIdSql,
            self::FETCH_ONE_MTHD,
            [$dealId, $userId, $parentId]
        );
    }

    public function fetchTeamMembersDueDiligenceForDeal (int $dealId, int $userId, int $dueDiligenceId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->teamMemberDdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId, $userId, $dueDiligenceId, $dueDiligenceId]
        );
    }

    public function fetchUserPurchasesDueDiligenceDealIds(int $userId)
    {
        $result = $this->buildAndExecuteFromSql($this->getEntityManager(),
            self::$userPurchaseDueDiligenceDealIdsSql, self::FETCH_ALL_KEY_VAL_MTHD, [$userId]
        );
        if (!is_array($result))
            return $result;
        return $this->flattenResultArrayByKey($result, self::QUERY_JUST_ID);
    }

    /**
     * @param array $userIds
     * @param array $dealIds
     * @param array $exceptIds
     * @return array|string
     */
    public function fetchDdIdsByUserIdsDealIds(array $userIds, array $dealIds, array $exceptIds=[0]):array|string
    {
        $results = $this->buildAndExecuteMultiIntStmt(
            $this->getEntityManager(),
            $this->fetchDdIdsByUserIdsDealIdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            $userIds, $dealIds, $exceptIds
        );

        try {
            if(count($results)) {
                $results = $this->flattenResultArrayByKey($results, 'id');
            } else {
                $results = [];
            }
            return $results;
        }catch (\Doctrine\DBAL\Driver\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * @param int $issuerId
     * @return mixed
     */
    public function fetchDealFileDataByDdIds(int $issuerId):mixed
    {
        return $this->executeProcedure([$issuerId],
            self::$callDealFileDataByIssuerDueDiligenceIds);
    }

    /**
     * @param int $issuerId
     * @return mixed
     */
    public function fetchDdIssuesDataByDdIds(int $issuerId):mixed
    {
        return $this->executeProcedure([$issuerId],
            self::$callIssuesDataByIssuerDueDiligenceIds);
    }

    /**
     * @param int $issuerId
     * @return mixed
     */
    public function fetchMsgIssuesDataByIssueIdsLoanIds(int $issuerId):mixed
    {
        return $this->executeProcedure([$issuerId],
            self::$callIssuesMsgsDataByIssuerDueDiligenceIds);
    }

    public function fetchMarketUserTeamDataByIssuerId(int $issuerId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::$dueDiligenceTeamDataSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$issuerId]
        );
    }

    public function fetchUserSellingFilesFilter (int $userIssuerId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::$sellingDealsFilterSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userIssuerId]
        );
    }

    public function fetchUserBuyingFilesFilter (int $userIssuerId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::$buyingDealsFilterSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userIssuerId]
        );
    }

    /**
     * @param array $ddIds
     * @param $loanIds
     * @return \Exception|mixed
     */
    public function fetchDdLoanStatusByDdIdLoanId(array $ddIds, $loanIds):mixed
    {
        try {
            $results = $this->buildAndExecuteMultiIntStmt(
                $this->getEntityManager(),
                self::$dueDilLoanStatusByDdIdsLoanIdsSql,
                self::FETCH_ALL_ASSO_MTHD,
                $ddIds, $loanIds
            );
        }catch (\Doctrine\DBAL\Driver\Exception  $err){
            $results = ['message' => $err->getMessage()];
        }
        return $results;
    }

    /**
     * @deprecated ToDo delete once all calls to method are deleted
     * @param int $issuerId
     * @param int $dealId
     * @return false|int|mixed[]
     * @throws \Doctrine\DBAL\Exception
     */
    public function fetchDdLeadUserIdByIssueIdDealId(int $issuerId, int $dealId)
    {
        $sql = 'SELECT user_id FROM DueDiligence dd ' .
            'LEFT JOIN MarketUser users on users.id=user_id ' .
            'WHERE issuer_id = ? AND dd.dd_role_id=1 AND dd.deal_id=?';
        try {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $sql,
                self::FETCH_ASSO_MTHD,
                [$issuerId, $dealId]
            );
        } catch (\Doctrine\DBAL\Driver\Exception $err){}

        if(array_key_exists('user_id', $result)){
            return (int)$result['user_id'];
        }
        return $result;
    }

    public function returnBaseInsertArray():array
    {
        $base = [];
        each(function ($props, $key) use(&$base) {
            if ($props[self::TBL_PROP_DEFAULT_KEY] === self::TBL_PROP_NONE_DEFAULT)
                $base[$key] = null;
            else
                $base[$key] = $props[self::TBL_PROP_DEFAULT_KEY];
        }, $this->tableProps);
        return $base;
    }

    public function returnTablePropsArray ():array { return $this->tableProps; }

    public function returnDealFileDdManyToManyProps ():array
    {
        return [
            self::MANY_TO_MANY_DD_ID_KEY => null,
            self::MANY_TO_MANY_FILE_ID_KEY => null
        ];
    }

    public function dueDilLeadsByDealIdLoanId(int $dealId, int $loanId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->ddLeadsByDealIdLoanIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId, $loanId]
        );
    }

    public function leadDueDilIdsUserIdsByDealId (int $dealId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->leadDdIdsUserIdsByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }

    public function allDueDilIdsUserIdsByFileId (int $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->allDdUserFileAccessSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$fileId]
        );
    }

    public function dueDilIdsUserIdsByDealId (int $dealId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->dueDilIdsUserIdsByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }

    public function dueDilIdsByUserId (int $userId):mixed
    {
        $query = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->userDueDiligenceIdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );
        if (count($query) > 0) {
            $query = array_map(function($item) {
                return $item[self::DD_QRY_ID_KEY];
            }, $query);
        }
        return $query;
    }

    public function addMultiDealFileDdInputs(array $dueDiligenceIds, array $filesIds)
    {  
        $base = $this->multipleInsertsDealFileDd;
        $ddInsertCount = 0;
        $fileInsertCount = 0;
        foreach ($dueDiligenceIds as $ddId) {
            $ddInsertCount++;
            foreach($filesIds as $fileId) {
                $fileInsertCount++;
                $base = $base . PHP_EOL .
                '(' . $ddId  . ',' . $fileId . ')'.
                    (
                        $ddInsertCount == count($dueDiligenceIds) &&
                        $fileInsertCount == count($filesIds) *
                        count($dueDiligenceIds) ? ';' : ','
                    );
            }
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }

    public function fetchUserCurrentDealFileDd(array $ddIds, int $fileId):mixed
    {
        try {
            return $this->buildAndExecuteMultiIntStmt(
                $this->getEntityManager(),
                $this->selectDealFileDueDiligenceByDdsAndFileId,
                self::FETCH_ALL_ASSO_MTHD,
                $ddIds, [$fileId]
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchDueDiligenceById(int $dueDiligenceId):mixed
    {
        try {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->fetchDueDiligenceByIdSql,
                self::FETCH_ASSO_MTHD,
                [$dueDiligenceId]
            );

            return !$result ? null : $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchDueDiligenceByParentAndUser(int $ddParentId, int $userId)
    {
        try {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->fetchDueDiligenceByParentAndUserSql,
                self::FETCH_ASSO_MTHD,
                [$ddParentId, $userId]
            );
            return !$result ? null : $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function fetchOneDfDdByDdAndLoan(int $dueDiligenceId, int $loanId)
    {
        try {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->fetchOneDfDdByDdAndLoanSql,
                self::FETCH_ASSO_MTHD,
                [$dueDiligenceId, $loanId]
            );
            return !$result ? null : $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
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

class DueDiligence extends DueDiligenceAbstract
{
    use FetchMapperTrait, FetchingTrait;

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserSaleDealIdsInDueDiligence (int $userId):mixed
    {
        return $this->executeProcedure([$userId], self::$callUserSaleDealIdsInDueDiligence);
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
        $sql = 'SELECT id FROM DueDiligence WHERE `user_id` IN (?) AND deal_id IN (?) AND id NOT IN (?)';
        $stmt = $this->returnMultiIntArraySqlStmt($this->getEntityManager(), $sql, $userIds, $dealIds, $exceptIds);
        try {
            $results = $stmt->fetchAllAssociative();
            if(count($results)){
                return $this->flattenResultArrayByKey($results, 'id');
            }
            return [];
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

    public function fetchMarketUserTeamDataByIssuerId(int $issuerId, int $userId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::$dueDiligenceTeamDataSql,
            self::FETCH_ASSO_MTHD,
            [$issuerId, $userId]
        );
    }

    /**
     * @param array $ddIds
     * @param $loanIds
     * @return \Exception|mixed
     */
    public function fetchDdLoanStatusByDdIdLoanId(array $ddIds, $loanIds):mixed
    {
        $stmt = $this->returnMultiIntArraySqlStmt(
            $this->getEntityManager(), self::$dueDilLoanStatusByDdIdsLoanIdsSql,
            $ddIds, $loanIds);
        try {
            $results = $stmt->fetchAllAssociative();
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
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindParam(1, $issuerId);
        $stmt->bindParam(2, $dealId);
        try {
            $result = $stmt->executeQuery()
            ->fetchAssociative();
        }catch (\Doctrine\DBAL\Driver\Exception $err){}

        if(array_key_exists('user_id', $result)){
            return (int)$result['user_id'];
        }
        return $result;
    }
}
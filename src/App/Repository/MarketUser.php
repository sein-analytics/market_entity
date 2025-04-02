<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:45 PM
 */

namespace App\Repository;


use App\Repository\MarketUser\abstractMktUser;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\Log;

class MarketUser extends abstractMktUser
    implements DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $updateUserStatusIdSql = "UPDATE MarketUser SET status_id=? WHERE id=?";

    private string $usernameStringByUserIdSql = "SELECT CONCAT(first_name, ' ', last_name) as userName FROM MarketUser WHERE id=?";

    private string $userRoleIdByUserIdSql = "SELECT role_id FROM `MarketUser` WHERE id = ?";

    function fetchUsersUuidFromIds(array $userIds)
    {
        $result = $this->executeProcedure([implode(', ', $userIds)],
            $this->callUsersUuidsFromIds
        );
        if ($result instanceof \Exception)
            return $result;
        return $this->flattenResultArrayByKey($result, 'uuid', false);
    }

    private function testBuildAndExecuteSql(EntityManager|EntityManagerInterface $em, string $sql,
                                            string $fetchMethod, array $params = [], bool $useIntArr = false):mixed
    {
        if (!$useIntArr){
            if (($stmt = $this->buildStmtFromSql($em, $sql, $params) ) instanceof \Exception)
                return $stmt;
            return $stmt;
        }
        return $sql;
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserNameStringByUserId(int $userId):mixed
    {
        return $this->testBuildAndExecuteSql(
            $this->getEntityManager(), $this->usernameStringByUserIdSql, self::FETCH_ALL_ASSO_MTHD, [$userId]);
        /*try {
            $stmt = $this->getEntityManager()->getConnection()
                ->prepare($this->usernameStringByUserIdSql);
            $stmt->bindValue(1, $userId);
            return  $stmt->executeQuery()->fetchAllAssociative();
        }catch (Exception|\Doctrine\DBAL\Driver\Exception $exception){
            return ['message' => $exception->getMessage()];
        }*/

        /*return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->usernameStringByUserIdSql,
            self::FETCH_ALL_ASSO_MTHD
            [$userId]
        );*/

        /*if (is_array($result) &&
            array_key_exists(self::USER_NAME_API_STRING, $result)){
            return $result[self::USER_NAME_API_STRING];
        }
        return false;*/
    }

    public function fetchUserRoleIdByUserId (int $userId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->userRoleIdByUserIdSql,
            self::FETCH_ASSO_MTHD,
            [$userId]
        );
    }

    /**
     * @param $userId
     * @return array|string
     */
    function fetchUserMarketDealIds(int $userId)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::getUserDealIdsSql(),
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );

        return $this->flattenResultArrayByKey($results, self::MKT_DEAL_ID_KEY);
    }

    public function fetchUserWatchlistDealIds(int $userId, bool $indexedResults = false)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::getUsrWatchlistIdsSql(),
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );

        $dealIds = $this->flattenResultArrayByKey($results, self::FAV_DEAL_ID_KEY, false);

        $results = !$indexedResults
            ? $dealIds
            : $this->mapRequestIdsToResults($dealIds, $results, self::FAV_DEAL_ID_KEY);
        return $results;
    }

    /**
     * @param int $userId
     * @param int $dealId
     * @param $sql
     * @return bool|\Exception
     */
    protected function completeWatchlistSql(int $userId, int $dealId, $sql)
    {
        $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            [$userId, $dealId]
        );

        return true;
    }

    /**
     * @param int $userId
     * @param int $dealId
     * @return bool|\Exception
     */
    public function removeDealFromUserWatchlist(int $userId, int $dealId) {
        return $this->completeWatchlistSql($userId, $dealId, self::getRmvFromWatchlistSql());
    }

    /**
     * @param int $userId
     * @param int $dealId
     * @return bool|\Exception
     */
    public function addDealToUserWatchlist(int $userId, int $dealId) {
        return $this->completeWatchlistSql($userId, $dealId, self::getAddToWatchlistSql());
    }

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchMarketUsersFromIds(array $ids)
    {
        return $this->fetchByIntArray($this->getEntityManager(), $ids, self::getUsersFromIdsArrSql());
    }

    /**
     * @param int $id
     * @return array|string
     */
    public function fetchUserDataForBidByUserId(int $id)
    {
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            "SELECT CONCAT(first_name, ' ', last_name) AS first_last, id, user_name, issuer_id FROM MarketUser WHERE id=?",
            self::FETCH_ASSO_MTHD,
            [$id]
        );

        return $result;
    }

    /**
     * @return array|bool
     */
    public function fetchAllMarketUserBuyerIds()
    {
        $roles = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::getBuyerIdsByRoleSql(),
            self::FETCH_ALL_ASSO_MTHD,
        );

        if(!is_array($roles) || count($roles) === 0){
            return false;
        }

        $rolesIds = $this->flattenResultArrayByKey($roles, 'id');

        $results = $this->fetchByIntArray($this->getEntityManager(),
            $rolesIds, self::getUserIdsByRoleIdSql());

        $results = $this->flattenResultArrayByKey($results, 'id');
        return $results;
    }

    public function fetchIssuerUserIdsByIssuerId(int $issuerId, int $exceptId=0)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::getUsrIdByIssuerIdSql(),
            self::FETCH_ALL_ASSO_MTHD,
            [$issuerId, $exceptId]
        );

        $results = $this->flattenResultArrayByKey($results, self::MKT_USR_DB_ID_KEY);

        return $results;
    }

    public function addNewMsgMarketUser(int $msgId, int $userId)
    {
        try{
            return $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                self::getInsertMsgIdUsrIdSql(),
                self::EXECUTE_MTHD,
                [$msgId, $userId]
            );
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function fetchUserFavoriteDeal(int $userId, int $dealId): mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->getUserFavoriteDealSql(),
            self::FETCH_ONE_MTHD,
            [$userId, $dealId]
        );
    }

    public function fetchUserRequestedKycDocuments(int $userId, int $issuerId, int $assetTypeId)
    {
        $result = $this->executeProcedure([$userId, $issuerId, $assetTypeId],
            $this->callFetchUserRequestedKycDocuments
        );
        return $result;
    }

    public function fetchUserDealsByStatus(int $userId, int $statusId): mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->getFetchDealsByUserAndStatusSql(),
            self::FETCH_ALL_ASSO_MTHD,
            [$userId, $statusId]
        );
    }

    public function fetchAllowedDealsByBidStatusAndDocType(int $userId, int $communityUserId, int $docTypeId, array $bidsStatusIds): mixed
    {
        $result = $this->executeProcedure([$userId, $communityUserId, $docTypeId, implode(', ', $bidsStatusIds)],
            $this->getCallFetchAllowedDealsByBidStatusAndDocType()
        );
        return $result;
    }

}
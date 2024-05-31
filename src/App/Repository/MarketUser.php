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
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\Log;

class MarketUser extends abstractMktUser
    implements DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $updateUserStatusIdSql = "UPDATE MarketUser SET status_id=? WHERE id=?";

    function fetchUsersUuidFromIds(array $userIds)
    {
        $result = $this->executeProcedure([implode(', ', $userIds)],
            $this->callUsersUuidsFromIds
        );
        if ($result instanceof \Exception)
            return $result;
        return $this->flattenResultArrayByKey($result, 'uuid', false);
    }

    /**
     * @param $userId
     * @return array|string
     */
    function fetchUserMarketDealIds(int $userId)
    {
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare(self::getUserDealIdsSql());
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
        $stmt->bindValue(1, $userId);
        try{
            $stmt->execute();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $this->flattenResultArrayByKey($results, self::MKT_DEAL_ID_KEY);
    }

    public function fetchUserWatchlistDealIds(int $userId, bool $indexedResults = false)
    {
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare(self::getUsrWatchlistIdsSql());
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
        $stmt->bindValue(1, $userId);
        try{
            $stmt->execute();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
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
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (\Exception $exception){
            return $exception;
        }
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $dealId);
        try {
            $stmt->execute();
        }catch (\Exception $exception){
            return $exception;
        }
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
     * @param int $userId
     * @return int|string
     */
    public function fetchIssuerIdByUserId(int $userId)
    {
        $sql = "SELECT issuer_id FROM MarketUser WHERE  id = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $stmt->bindValue(1, $userId);
        $result = (int)$stmt->fetch(Query::HYDRATE_ARRAY)[$userId];
        $stmt->closeCursor();
        return $result;
    }

    /**
     * @param int $id
     * @return array|string
     */
    public function fetchUserDataForBidByUserId(int $id)
    {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS first_last, id, user_name, issuer_id  FROM MarketUser WHERE  id = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $stmt->bindValue(1, $id);
        try {
            $stmt->execute();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $result;
    }

    /**
     * @return array|bool
     */
    public function fetchAllMarketUserBuyerIds()
    {
        $roles = $this->getEntityManager()
            ->getConnection()->fetchAll(self::getBuyerIdsByRoleSql());
        if(!is_array($roles)
            || count($roles) === 0){
            return false;
        }
        $rolesIds = $this->flattenResultArrayByKey($roles, 'id');
        $results = $this->fetchByIntArray($this->getEntityManager(),
            $rolesIds, self::getUserIdsByRoleIdSql());
        if(!is_array($roles) || count($roles) === 0){
            return false;
        }
        $results = $this->flattenResultArrayByKey($results, 'id');
        return $results;
    }

    public function fetchMarketUserSaltByEmail(string $email)
    {
        try{
            $stmt = $this->getEntityManager()
                ->getConnection()->prepare(self::getUserSaltByEmailSql());
        } catch (\Exception $e){
            return false;
        }
        $stmt->bindParam(1, $email);
        try {
            $stmt->execute();
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $result;
    }

    public function fetchIssuerUserIdsByIssuerId(int $issuerId, int $exceptId=0)
    {
        $stmt = $this->getEntityManager()
            ->getConnection()->prepare(self::getUsrIdByIssuerIdSql());
        $stmt->bindParam(1, $issuerId);
        $stmt->bindParam(2, $exceptId);
        $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $this->flattenResultArrayByKey($result, self::MKT_USR_DB_ID_KEY);
    }

    public function addNewMsgMarketUser(int $msgId, int $userId)
    {
        try{
            $stmt = $this->getEntityManager()
                ->getConnection()->prepare(self::getInsertMsgIdUsrIdSql());
            $stmt->bindParam(1, $msgId);
            $stmt->bindParam(2, $userId);
        } catch (\Exception $e){
            return $e->getMessage();
        }
        return $stmt->execute();
    }

    /**
     * @param int $userId
     * @return array|bool|string
     */
    public function fetchLeaderTeamIdsFromLeaderId(int $userId)
    {
        try{
            $stmt = $this->getEntityManager()
                ->getConnection()->prepare(self::getTeamLeadIdFromUsrIdAndIssuerSql());
            $stmt->bindValue(1, $userId);
        } catch (DBALException $e){
            return $e->getMessage();
        }
        return $this->completeIdFetchQuery($stmt);
    }

    public function updateRememberTokenById(string $token, int $id)
    {
        try {
            $stmt = $this->getEntityManager()
                ->getConnection()->prepare(self::getUpdateRemTokenByUsrIdSql());
            $stmt->bindParam(1, $token);
            $stmt->bindParam(2, $id);
        } catch (\Exception $exception){
            return false;
        }
        try {
            $stmt->execute();
        }catch (\Exception $exception){
            return  false;
        }
        return true;
    }

    public function fetchUserIdByToken(string $token)
    {
        $sql = "SELECT id FROM MarketUser where remember_token=$token";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (\Exception $exception){
            return false;
        }
        try {
            $stmt->execute();
        }catch (\Exception $exception){
            return  false;
        }
        return $stmt->fetch([Query::HYDRATE_SCALAR]);
    }

    public function updateAuthyTokenById(string $token, int $id)
    {
        try {
            $stmt = $this->getEntityManager()
                ->getConnection()->prepare(self::getUpdateAuthTokenByUsrIdSql());
            $stmt->bindParam(1, $token);
            $stmt->bindParam(2, $id);
        } catch (\Exception $exception){
            return false;
        }
        try {
            $stmt->execute();
        }catch (\Exception $exception){
            return  false;
        }
        return true;
    }

    public function fetchMarketUserById($userId)
    {
        /** @var  $query Query */
        $query = $this->getEntityManager()->createQuery('SELECT * FROM MarketUser where id=:id');
        $query->setParameter('id', $userId);
        return $query->getResult(AbstractQuery::HYDRATE_OBJECT);
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

    public function insertNewKycDocument(array $params):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertKycDocRequestSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
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

    public function fetchAllowedDealsNonDisclosure(int $userId, int $communityIssuerId): mixed
    {
        $result = $this->executeProcedure([$userId, $communityIssuerId],
            $this->getCallFetchAllowedDealsNonDisclosure()
        );
        return $result;
    }

    public function fetchAllowedDealsByBidStatusAndDocType(int $userId, int $communityUserId, int $docTypeId, array $bidsStatusIds): mixed
    {
        $result = $this->executeProcedure([$userId, $communityUserId, $docTypeId, implode(', ', $bidsStatusIds)],
            $this->getCallFetchAllowedDealsByBidStatusAndDocType()
        );
        return $result;
    }

}
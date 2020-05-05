<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:45 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\Log;

class MarketUser extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    /**
     * @param $userId
     * @return array|string
     */
    function fetchUserMarketDealIds(int $userId)
    {
        $sql = "SELECT deal_id FROM deal_market_user WHERE  market_user_id = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
        return $this->flattenResultArrayByKey($results, 'deal_id');
    }

    public function fetchUserWatchlistDealIds(int $userId)
    {
        $sql = "SELECT favorite_deal_id FROM user_favorite_deals WHERE  user_id = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
        return $this->flattenResultArrayByKey($results, 'favorite_deal_id');
    }

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchMarketUsersFromIds(array $ids)
    {
        $sql = "SELECT * FROM MarketUser WHERE id IN (?) ORDER BY id ASC";
        $results = $this->fetchByIntArray($this->getEntityManager(), $ids, $sql);
        return $results;
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
        $sql = "SELECT id FROM AclRole WHERE role='Buyer' OR role='Both'";
        $roles = $this->getEntityManager()->getConnection()->fetchAll($sql);
        if(!is_array($roles)
            || count($roles) === 0){
            return false;
        }
        $rolesIds = $this->flattenResultArrayByKey($roles, 'id');
        $sql = "SELECT id FROM MarketUser WHERE role_id in (?) ORDER BY id ASC ";
        $results = $this->fetchByIntArray($this->getEntityManager(), $rolesIds, $sql);
        if(!is_array($roles) || count($roles) === 0){
            return false;
        }
        $results = $this->flattenResultArrayByKey($results, 'id');
        return $results;
    }

    public function fetchMarketUserSaltByEmail(string $email)
    {
        $sql = "SELECT user_salt FROM MarketUser WHERE email = ? ";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
        $sql = "SELECT id FROM MarketUser WHERE issuer_id = ? AND id != ? ORDER BY id ASC ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindParam(1, $issuerId);
        $stmt->bindParam(2, $exceptId);
        $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $this->flattenResultArrayByKey($result, 'id');
    }

    public function addNewMsgMarketUser(int $msgId, int $userId)
    {
        $sql = "INSERT INTO `market_user_message` (`message_id`, `market_user_id`) VALUES (?, ?) ";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
        $sql = "SELECT id from MarketUser m1 " .
            "WHERE m1.issuer_id = (SELECT issuer_id FROM MarketUser WHERE id = ?)";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->bindValue(1, $userId);
        } catch (DBALException $e){
            return $e->getMessage();
        }
        return $this->completeIdFetchQuery($stmt);
    }

    public function updateRememberTokenById(string $token, int $id)
    {
        $sql = "UPDATE `MarketUser` SET `remember_token`= ? WHere id= ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
        $sql = "UPDATE `MarketUser` SET `authy_token`= ? WHere id= ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
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
}
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
use Doctrine\ORM\Query;

class MarketUser extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    /**
     * @param $userId
     * @return array
     */
    function fetchUserMarketDealIds(int $userId)
    {
        $sql = "SELECT deal_id FROM deal_market_user WHERE  market_user_id = ?";
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $this->flattenResultArrayByKey($results, 'deal_id');
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
     * @return int
     */
    public function fetchIssuerIdByUserId(int $userId)
    {
        $sql = "SELECT issuer_id FROM MarketUser WHERE  id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $result = (int)$stmt->fetch(Query::HYDRATE_ARRAY)[$userId];
        return $result;
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchUserDataForBidByUserId(int $id)
    {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS first_last, id, user_name, issuer_id  FROM MarketUser WHERE  id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
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

    public function fetchIssuerUserIdsByIssuerId(int $issuerId, int $exceptId=0)
    {
        $sql = "SELECT id FROM MarketUser WHERE issuer_id = ? AND id != ? ORDER BY id ASC ";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindParam(1, $issuerId);
        $stmt->bindParam(2, $exceptId);
        $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
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
        $sql = "select id from MarketUser m1 " .
            "WHERE m1.issuer_id = (SELECT issuer_id FROM MarketUser WHERE id = ?)";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->bindValue(1, $userId);
        } catch (DBALException $e){
            return $e->getMessage();
        }
        return $this->completeIdFetchQuery($stmt);
    }
}
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

    public function fetchUserDataForBidByUserId(int $id)
    {
        $sql = "SELECT id, first_name, last_name, user_name, issuer_id CONCAT(first_name, ' ', last_name) AS first_last FROM MarketUser WHERE  id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
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
}
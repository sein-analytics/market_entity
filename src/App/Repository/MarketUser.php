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
     * @param array $dealIds
     * @return array|bool
     */
    public function fetchMarketUsersFromIds(array $dealIds)
    {
        $sql = "SELECT * FROM MarketUser WHERE id IN (?) ORDER BY id ASC";
        $results = $this->fetchByIntArray($this->getEntityManager(), $dealIds, $sql);
        return $results;
    }

    /**
     * @return array|bool
     */
    public function fetchAllMarketUserBuyerIds()
    {
        $sql = "SELECT * FROM AclROle";
        $roles = $this->getEntityManager()->getConnection()->fetchAll($sql);
        $roleIds = [];
        foreach ($roles as $role){
            if($role['role'] === 'Buyer'){
                array_push($roleIds, $role['id']);
            }
        }
        $sql = "SELECT id FROM MarketUser WHERE role_id in () ORDER BY id ASC ";
        if(count($roleIds) === 0){
            return false;
        }
        $results = $this->fetchByIntArray($this->getEntityManager(), $roleIds, $sql);
        return $results;
    }
}
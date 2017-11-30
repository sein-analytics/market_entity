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
        $stmt= $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $this->flattenResultArrayByKey($results, 'deal_id');
    }

    /**
     * @param array $dealIds
     * @return array|bool
     */
    public function fetchMarketUsersFromIds(array $dealIds){
        $sql = "SELECT * FROM MarketUser WHERE id IN (?) ORDER BY id ASC";
        $results = $this->fetchByIntArray($this->em, $dealIds, $sql);
        return $results;
    }
}
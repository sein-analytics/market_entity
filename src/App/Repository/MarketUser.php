<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:45 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class MarketUser extends EntityRepository
{
    function fetchUserMarketDealIds($userId)
    {
        $sql = "SELECT deal_id FROM deal_market_user WHERE  market_user_id = ?";
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $this->flattenHydration($results, 'deal_id');
    }

    function flattenHydration(array $hydration, $key)
    {
        $flat = [];
        foreach ($hydration as $dataPoint){
            array_push($flat, str_replace('"', "",$dataPoint[$key]));
        }
        return $flat;
    }

    public function fetchMarketUsersFromIds(array $dealIds){
        $stmt = $this->getEntityManager()->getConnection()->executeQuery("Select * FROM MarketUser WHERE id IN (?)",
            array($dealIds),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }
}
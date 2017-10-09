<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:45 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class MarketUser extends EntityRepository
{
    function fetchUserMarketDealIds($userId)
    {
        $dql = 'SELECT u FROM MarketUser u INNER JOIN deal_market_user WHERE deal_market_user.market_user_id = ?1';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $userId);
        $result = $query->getResult();
        return $result;
    }
}
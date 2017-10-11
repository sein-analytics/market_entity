<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/9/17
 * Time: 5:56 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

/**
 * Class Bid
 * @package App\Repository
 */
class Bid extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;
    const BID_DEAL = "deal_id";

    /**
     * @param array $dealIds
     * @param bool $mapBidsToDeals
     * @return array
     */
    public function fetchBidsForDealIds(array $dealIds, $mapBidsToDeals = true)
    {
        $results = $this->fetchByIntArray($this->getEntityManager(), $dealIds, $sql);
        if ($mapBidsToDeals
            && count($results ) > 0)
        {
            $results = $this->mapRequestIdsToResults($dealIds, $results, self::BID_DEAL);
        }
        return $results;
    }
}
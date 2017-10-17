<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/10/17
 * Time: 10:04 AM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class Statistic extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    /**
     * @param array $dealIds
     * @param bool $mapStatisticsToDeal
     * @return array|bool
     */
    public function fetchDealStatisticsByDealIds(array $dealIds, $mapStatisticsToDeal = true)
    {
        $sql = 'SELECT * FROM Statistic WHERE deal_id IN (?)';
        $results = $this->fetchByIntArray($this->getEntityManager(), $dealIds, $sql);
        if(count($results) > 0 && $mapStatisticsToDeal){
            $results = $this->mapRequestIdsToResults($dealIds, $results, "deal_id");
        }
        return $results;
    }

}
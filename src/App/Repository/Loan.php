<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 5:31 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class Loan extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchLoansByDealId(int $dealId)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT * FROM Pool WHERE deal_id IN (?)";
        $results = $this->fetchByIntArray($em, array($dealId), $sql);
        if(count($results) > 0){
            $results = $this->fetchLoansByPoolIds(array($results[0]['id']));
        }
        return $results;
    }

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchLoansByPoolIds(array $ids)
    {
        $sql = "SELECT * FROM loans WHERE pool_id IN (?) ORDER BY pool_id ASC ";
        $results = $this->fetchByIntArray($this->getEntityManager(), $ids, $sql);
        return $results;
    }

}
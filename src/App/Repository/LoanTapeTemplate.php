<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 2:16 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class LoanTapeTemplate extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;

    public function fetchUserLoanTemplates(array $userId)
    {
        $sql = "SELECT * FROM LoanTapeTemplate WHERE user_id in (?) ORDER BY id ASC";
        $results = $this->fetchByIntArray($this->getEntityManager(), $userId, $sql);
        return $results;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:32 PM
 */

namespace App\Repository;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class Deal extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    public function fetchUserDealsFromIds(array $ids)
    {
        $sql = 'SELECT * FROM Deal WHERE status_id = 1 AND id IN (?) ORDER BY id ASC';
        $results = $this->fetchByIntArray($this->getEntityManager(), $ids, $sql);
        return $results;
    }

}
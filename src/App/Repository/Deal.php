<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:32 PM
 */

namespace App\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Deal extends EntityRepository
{
    public function fetchUserDealsFromIds(array $ids)
    {
        $stmt = $this->getEntityManager()->getConnection()->executeQuery('SELECT * FROM Deal WHERE status_id = 1 AND id IN (?)',
            array($ids),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

}
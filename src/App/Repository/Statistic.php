<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/10/17
 * Time: 10:04 AM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Statistic extends EntityRepository
{
    public function fetchDealStatisticsByDealIds(array $dealIds)
    {
        $stmt = $this->getEntityManager()->getConnection()->executeQuery('SELECT * FROM Statistic WHERE deal_id IN (?)',
            array($dealIds),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

}
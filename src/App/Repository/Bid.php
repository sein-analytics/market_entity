<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/9/17
 * Time: 5:56 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Bid extends EntityRepository
{
    public function getBidsForDealIds(array $dealIds)
    {
        $stmt = $this->getEntityManager()->getConnection()->executeQuery('SELECT * FROM Bid WHERE deal_id IN (?)',
            array($dealIds),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

}
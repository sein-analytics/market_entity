<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/9/18
 * Time: 3:00 PM
 */

namespace App\Repository;


use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DueDiligence extends EntityRepository
{
    use FetchMapperTrait;

    /**
     * @param array $userIds
     * @param array $dealIds
     * @param array $exceptIds
     * @return array
     */
    public function fetchDdIdsByUserIdsDealIds(array $userIds, array $dealIds, array $exceptIds=[0])
    {
        $sql = 'SELECT id FROM DueDiligence WHERE `user_id` IN (?) AND deal_id IN (?) AND id NOT IN (?)';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($userIds, $dealIds, $exceptIds),
            array(Connection::PARAM_INT_ARRAY,
                Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        if(count($results)){
            return $this->flattenResultArrayByKey($results, 'id');
        }
        return $results;
    }
}
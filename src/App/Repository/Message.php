<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/18/18
 * Time: 2:04 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Message extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    public function fetchMessageIdsFromUserMessage(int $userId)
    {
        $sql = "SELECT message_id FROM market_user_message WHERE market_user_id = ?";
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $this->flattenResultArrayByKey($results, 'message_id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 8/16/18
 * Time: 6:10 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;

class AclRole extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;

    /**
     * @param int $userId
     * @return array|bool|string
     */
    public function fetchUserRoleIdFromUserId(int $userId)
    {
        $sql = "SELECT role_id AS id FROM MarketUser WHERE MarketUser.id=?";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->bindValue(1, $userId);
        } catch (\Exception $e){
            return $e->getMessage();
        }
        return $this->completeIdFetchQuery($stmt);
    }

}
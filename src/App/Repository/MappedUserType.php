<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/7/17
 * Time: 10:42 AM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class MappedUserType extends EntityRepository
{
    public function fetchUserMappedTypes($userId)
    {
        $result = $this->em->getConnection()->fetchAll("SELECT * FROM MappedUserType WHERE user_id=$userId");
        return $result;
    }
}
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
    public function fetchUserDeals($userId)
    {
        //
    }

}
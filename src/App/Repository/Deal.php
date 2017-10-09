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
    public function fetchUserDealIds($userId)
    {
        $connection = $this->getEntityManager()->getConnection();
        $repo =
        //$dql = 'SELECT s FROM App\\Entity\\Deal s WHERE s.level = 0';
        $query = $this->getEntityManager()->createQuery('');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function returnEntityManager()
    {
        $em = $this->getEntityManager();
        return $em;
    }
}
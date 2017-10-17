<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/17/17
 * Time: 9:09 AM
 */

namespace App\Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DealAsset extends EntityRepository
{
    public function fetchDealAssetTypes()
    {
        $dql = 'SELECT * FROM \\App\\Entity\\DealAsset';
        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult(Query::HYDRATE_OBJECT);
        return $result;
    }
}
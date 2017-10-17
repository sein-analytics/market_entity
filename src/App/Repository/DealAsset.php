<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/17/17
 * Time: 9:09 AM
 */

namespace App\Repository;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DealAsset extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    function fetchDealAssetTypes()
    {
        $dql = 'SELECT * FROM \\App\\Entity\\DealAsset';
        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getResult(Query::HYDRATE_OBJECT);
        return $result;
    }
}
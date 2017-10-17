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

    function fetchDealAssetTypes($object = true)
    {
        if($object){
            $query = $this->getEntityManager()->createQuery("SELECT t FROM \App\Entity\DealAsset t WHERE t.id > 1");
            $result = $query->getResult();
        }else {
            $result = $query = $this->getEntityManager()->getConnection()->fetchAll("SELECT * FROM DealAsset");
        }
        return $result;
    }
}
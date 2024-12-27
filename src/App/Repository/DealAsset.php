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
use Doctrine\ORM\EntityRepository;
use App\Repository\DbalStatementInterface;

class DealAsset extends EntityRepository
    implements DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $fetchObjectDealAssetTypesSql = "SELECT t FROM \App\Entity\DealAsset t WHERE t.id > 0";

    private string $fetchAllDealAssetTypesSql = "SELECT * FROM DealAsset";

    /**
     * @param bool $object
     * @return array
     */
    function fetchDealAssetTypes($object = true)
    {
        if($object){
            $query = $this->getEntityManager()->createQuery($this->fetchObjectDealAssetTypesSql);
            $result = $query->getResult();
        }else {
            $result = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->fetchAllDealAssetTypesSql,
                self::FETCH_ALL_ASSO_MTHD,
                []
            );
        }
        return $result;
    }
}
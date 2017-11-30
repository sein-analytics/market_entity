<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 10:07 AM
 */

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class Pool extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Pool');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        $reflector = $this->entityReflectorFromEntityName('App\Entity\Pool');
        return $this->entityPropertiesFromReflector($reflector);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 2:14 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class Issuer extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Issuer');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        $reflector = $this->entityReflectorFromEntityName('App\Entity\Issuer');
        return $this->entityPropertiesFromReflector($reflector);
    }
}
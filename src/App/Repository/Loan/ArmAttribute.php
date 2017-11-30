<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 10:51 AM
 */

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class ArmAttribute extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('ArmAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        $reflector = $this->entityReflectorFromEntityName('App\Entity\Loan\ArmAttribute');
        return $this->entityPropertiesFromReflector($reflector);
    }
}
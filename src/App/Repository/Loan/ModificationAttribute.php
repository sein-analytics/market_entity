<?php

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;

class ModificationAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('AddTableName');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        // TODO: Implement fetchEntityPropertiesForSql() method.
    }
}
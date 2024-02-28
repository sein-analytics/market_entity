<?php

namespace App\Repository\Deal;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

abstract class DealAbstract extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, DealInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;
}
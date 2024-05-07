<?php

namespace App\Repository\Deal;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class DealAbstract extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, DealInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

}
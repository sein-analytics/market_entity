<?php

namespace App\Repository\DealContract;
use Doctrine\ORM\EntityRepository;
use App\Repository\DbalStatementInterface;
use App\Repository\Deal\DealInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

abstract class DealContractAbstract extends EntityRepository
    implements DbalStatementInterface, DealInterface, DealContractInterface
{

    use FetchingTrait, FetchMapperTrait;

}
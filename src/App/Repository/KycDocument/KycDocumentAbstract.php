<?php

namespace App\Repository\KycDocument;
use Doctrine\ORM\EntityRepository;
use App\Repository\DbalStatementInterface;
use App\Repository\Deal\DealInterface;
use App\Repository\DealContract\DealContractInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

abstract class KycDocumentAbstract extends EntityRepository
    implements DbalStatementInterface, DealInterface, DealContractInterface, KycDocumentInterface
{

    use FetchingTrait, FetchMapperTrait;

}
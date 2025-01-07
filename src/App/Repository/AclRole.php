<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 8/16/18
 * Time: 6:10 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;

class AclRole extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;


}
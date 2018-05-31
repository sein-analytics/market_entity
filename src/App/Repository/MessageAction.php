<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 5/30/18
 * Time: 5:59 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;

class MessageAction extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;
}
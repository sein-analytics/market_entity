<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 4:17 PM
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;
use LaravelDoctrine\ORM\Facades\Registry;

abstract class ServiceAbstract
{
    protected $em;

    function __construct()
    {
        $this->em = EntityManager::create(connection_status());
    }
}
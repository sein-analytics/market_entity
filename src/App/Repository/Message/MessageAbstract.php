<?php

namespace App\Repository\Message;
use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityRepository;

class MessageAbstract extends EntityRepository
    implements DbalStatementInterface, MessageInterface
{

}
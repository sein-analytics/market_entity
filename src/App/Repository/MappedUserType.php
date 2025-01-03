<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/7/17
 * Time: 10:42 AM
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Service\FetchMapperTrait;
use App\Service\FetchingTrait;

class MappedUserType extends EntityRepository implements DbalStatementInterface
{

    use FetchingTrait, FetchMapperTrait;

    private string $fetchUserMappedTypesSql = "SELECT * FROM MappedUserType WHERE user_id=?";

    public function fetchUserMappedTypes($userId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchUserMappedTypesSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );
    }
}
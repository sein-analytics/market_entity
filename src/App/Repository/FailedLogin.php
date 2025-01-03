<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class FailedLogin extends EntityRepository
    implements FailedLoginInterface, DbalStatementInterface
{

    use FetchMapperTrait, FetchingTrait;

    private string $updateUserFailAttemptsByUserNameSql = "UPDATE MarketUser SET failed_attempt_id=? WHERE user_name=?";

    private string $fetchFailedLoginIdByUserNameSql = "SELECT CAST(`failed_attempt_id` AS UNSIGNED) FROM MarketUser WHERE user_name=?";

    public function updateUserFailAttemptsByUserName(int $id, string $userName)
    {
        if (array_key_exists($id, self::UPDATE_FAIL_ID)){
            $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $this->updateUserFailAttemptsByUserNameSql,
                self::EXECUTE_MTHD,
                [self::UPDATE_FAIL_ID[$id], $userName]
            );
            return true;
        }
        return false;
    }

    public function fetchFailedLoginIdByUserName(string $user)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchFailedLoginIdByUserNameSql,
            self::FETCH_ASSO_MTHD,
            [$user]
        );
    }

}
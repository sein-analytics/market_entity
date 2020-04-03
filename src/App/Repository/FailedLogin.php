<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class FailedLogin extends EntityRepository
    implements FailedLoginInterface
{
    public function updateUserFailAttemptsByUserName(int $id, string $userName)
    {
        if (array_key_exists($id, self::UPDATE_FAIL_ID)){
            $updateId = self::UPDATE_FAIL_ID[$id];
            $sql = "UPDATE MarketUser SET failed_attempt_id=$updateId WHERE user_name=$userName";
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            return true;
        }
        return false;
    }

    public function fetchFailedLoginIdByUserName(string $user)
    {
        $sql = "SELECT CAST(`failed_attempt_id` AS UNSIGNED) FROM MarketUser WHERE user_name=$user";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->fetch(Query::HYDRATE_SINGLE_SCALAR);
        $stmt->closeCursor();
        return $result;
    }
}
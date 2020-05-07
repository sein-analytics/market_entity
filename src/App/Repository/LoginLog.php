<?php

namespace App\Repository;

use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class LoginLog extends EntityRepository
{
    use FetchMapperTrait;

    const INSERT_STMT = '';

    const ID_KEY = 'id';

    const IP_KEY = 'ip';

    const EMAIL_KEY = 'email';

    const TOKEN_KEY = 'token';

    const START_KEY = 'start_time';

    const END_KEY = 'end_time';

    const BASE_DUR = '00:00:00';

    const LAST_SEEN_KEY = 'last_seen';

    /**
     * @param int $id
     * @return array|DBALException|\Exception
     */
    function fetchIpsByUserId(int $id)
    {
        $sql = "SELECT ip FROM LoginLog WHERE mobile_confirmation IS NOT NULL AND user_id=?";
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $id);
        if(!($stmt = $this->executeStmt($stmt)))
            return $stmt;
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        if (is_array($result))
            return $this->flattenResultArrayByKey($result, self::IP_KEY);
        return $result;
    }

    /**
     * @param int $id
     * @return bool|DBALException|\Exception
     */
    function logoutUpdateByUserId(int $id)
    {
        if (($result = $this->updateSessionEndByUserId($id)) instanceof \Exception)
            return $result;
        if (($result = $this->updateSessionDurationByUserId($id)) instanceof \Exception){
            return $result;
        }
        if (($result = $this->nullifyAuthyAtLogoutByUserId($id)) instanceof \Exception){
            return $result;
        }
        return true;
    }

    /**
     * @param int $id
     * @param int $minutes
     * @return DBALException|\Exception
     */
    function updateSessionEndByUserId(int $id, $minutes=0)
    {
        $sql = "UPDATE LoginLog SET end_time=(NOW() + INTERVAL ? MINUTE) WHERE user_id=? AND mobile_confirmation IS NOT NULL";
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $minutes);
        $stmt->bindValue(2, $id);
        return $this->executeStmt($stmt);
    }

    /**
     * @param int $id
     * @return DBALException|\Exception
     */
    function updateSessionDurationByUserId(int $id)
    {
        $sql = "UPDATE LoginLog SET `session_duration`= TIMEDIFF(start_time, end_time) WHERE user_id =? AND mobile_confirmation IS NOT NULL";
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $id);
        return $this->executeStmt($stmt);
    }

    /**
     * @param int $id
     * @return bool|DBALException|\Exception
     */
    function nullifyAuthyAtLogoutByUserId(int $id)
    {
        $sql = "UPDATE LoginLog SET mobile_confirmation=NULL WHERE user_id = ? AND mobile_confirmation IS NOT NULL";
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $id);
        return $this->executeStmt($stmt);
    }

    /**
     * @param array $credentialsArr
     * @return bool|DBALException|\Exception
     */
    function insertNewLoginLog(array $credentialsArr)
    {
        $sql = "INSERT INTO LoginLog (`id`, `user_id`, `ip`, `user_name`, `mobile_confirmation`, `start_time`, `end_time`, `session_duration`, `last_seen`) VALUES";
        if (!($credentials = $this->doesArrayHaveRequiredInputs($credentialsArr)))
            return ['message' => "Missing required keys in the credentials array"];
        $sql .= '(' . 0 . ',' . $credentials[self::ID_KEY] . ',' . '"' . $credentials[self::IP_KEY] . '"' . ',' . '"' . $credentials[self::EMAIL_KEY];
        $sql .= '"' . ',' . $credentials[self::TOKEN_KEY] . ',' . '"' . $credentials[self::START_KEY] . '"' .',';
        $sql .= '"'. $credentials[self::END_KEY] . '"' . ',' . '"' . self::BASE_DUR . '"' . ',' . '"' . $credentials[self::START_KEY] . '"' . ');';
        $stmt = $this->prepareSql($sql);
        return $this->executeStmt($stmt);
    }

    function updateLastSeenByUserId(\DateTime $lastSeen, int $userId)
    {
        $sql = 'Update LoginLog set `last_seen`=? WHERE `user_id`=? AND mobile_confirmation IS NOT NULL';
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $lastSeen->format('Y-m-d H:i:s'));
        $stmt->bindValue(2, $userId);
        return $this->executeStmt($stmt);
    }

    /**
     * @param array $credentials
     * @return array|bool
     */
    function doesArrayHaveRequiredInputs(array $credentials)
    {
        if(!array_key_exists(self::ID_KEY, $credentials))
            return false;
        if(!array_key_exists(self::TOKEN_KEY, $credentials))
            return false;
        if(!array_key_exists(self::IP_KEY, $credentials))
            return false;
        if(!array_key_exists(self::EMAIL_KEY, $credentials))
            return false;
        if(!array_key_exists(self::END_KEY, $credentials)
            || !$credentials[self::END_KEY] instanceof \DateTime)
            return false;
        if(!array_key_exists(self::START_KEY, $credentials)
            || !$credentials[self::START_KEY] instanceof \DateTime)
            return false;
        $credentials[self::START_KEY] = $credentials[self::START_KEY]->format('Y-m-d H:i:s');
        $credentials[self::END_KEY] = $credentials[self::END_KEY]->format('Y-m-d H:i:s');
        return $credentials;
    }

    /**
     * @param $sql
     * @return DBALException|\Doctrine\DBAL\Statement|\Exception
     */
    protected function prepareSql($sql)
    {
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (DBALException $e){
            return $e;
        }
        return $stmt;
    }

    /**
     * @param Statement $stmt
     * @return DBALException|Statement|\Exception
     */
    protected function executeStmt(Statement $stmt)
    {
        try {
            $stmt->execute();
        }catch (DBALException $e){
            return $e;
        }
        return $stmt;
    }
}
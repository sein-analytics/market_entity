<?php

namespace App\Repository;

use App\Service\FetchMapperTrait;
use App\Service\FetchingTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;

class LoginLog extends EntityRepository
    implements DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    const INSERT_STMT = '';

    const ID_KEY = 'id';

    const IP_KEY = 'ip';

    const EMAIL_KEY = 'email';

    const TOKEN_KEY = 'token';

    const START_KEY = 'start_time';

    const END_KEY = 'end_time';

    const BASE_DUR = '00:00:00';

    const LAST_SEEN_KEY = 'last_seen';

    private string $fetchIpsByUserIdSql = "SELECT ip FROM LoginLog WHERE mobile_confirmation IS NOT NULL AND user_id=?";

    private string $updateSessionEndByUserIdSql = "UPDATE LoginLog SET end_time=(NOW() + INTERVAL ? MINUTE) WHERE user_id=? AND mobile_confirmation IS NOT NULL";

    private string $updateSessionDurationByUserIdSql = "UPDATE LoginLog SET `session_duration`= TIMEDIFF(start_time, end_time) WHERE user_id =? AND mobile_confirmation IS NOT NULL";

    private string $nullifyAuthyAtLogoutByUserIdSql = "UPDATE LoginLog SET mobile_confirmation=NULL WHERE user_id = ? AND mobile_confirmation IS NOT NULL";

    /**
     * @param int $id
     * @return array|DBALException|\Exception
     */
    function fetchIpsByUserId(int $id)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchIpsByUserIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$id]
        );

        $results = $this->flattenResultArrayByKey($results, self::IP_KEY);

        return $results;
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
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateSessionEndByUserIdSql,
            self::EXECUTE_MTHD,
            [$minutes, $id]
        );
    }

    /**
     * @param int $id
     * @return DBALException|\Exception
     */
    function updateSessionDurationByUserId(int $id)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateSessionDurationByUserIdSql,
            self::EXECUTE_MTHD,
            [$id]
        );
    }

    /**
     * @param int $id
     * @return bool|DBALException|\Exception
     */
    function nullifyAuthyAtLogoutByUserId(int $id)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->nullifyAuthyAtLogoutByUserIdSql,
            self::EXECUTE_MTHD,
            [$id]
        );
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

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            []
        );
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

}
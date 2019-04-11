<?php

namespace App\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class LoginLog extends EntityRepository
{
    /**
     * @param int $id
     * @return array|DBALException|\Exception
     */
    function fetchIpsByUserId(int $id)
    {
        $sql = "SELECT IP FROM LoginLog WHERE mobile_confirmation IS NOT NULL AND session_duration = 0 AND user_id=?";
        if(!($stmt = $this->prepareSql($sql)) instanceof Statement)
            return $stmt;
        $stmt->bindValue(1, $id);
        if(!($stmt = $this->executeStmt($stmt)))
            return $stmt;
        return $stmt->fetchAll(Query::HYDRATE_ARRAY);
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
        $sql = "UPDATE LoginLog SET `session_duration`= TIMEDIFF(end_time, start_time) WHERE user_id =? AND mobile_confirmation IS NOT NULL";
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
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 11:18 AM
 */

namespace App\Service;


use App\Repository\RepositoryException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\Log;
use function Lambdish\phunctional\{each};

trait FetchingTrait
{
    /** @var RepositoryException */
    protected $repoException;

    /**
     * @param EntityManager $em
     * @param array $keys
     * @param string $sql
     * @return array|bool
     */
    public function fetchByIntArray(EntityManager $em, array $keys, string $sql){
        if(!count($keys) > 0) { return false; }
        $stmt = $this->returnInArraySqlStmt($em, $keys, $sql);
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY); //$stmt->fetchAllAssociative();
        return $results;
    }

    /**
     * @param string $key
     * @param array $array
     * @return array
     */
    public function array_value_recursive(string $key, array $array)
    {
        $val = [];
        array_walk_recursive($array, function ($v, $k) use($key, &$val) {
            if ($k == $key) array_push($val, $v);
        });
        return $val;
    }

    /**
     * @param EntityManager $em
     * @param array $keys
     * @param string $sql
     * @return Statement
     */
    public function returnInArraySqlStmt(EntityManager $em, array $keys, string $sql)
    {
        $stmt = $em->getConnection()->executeQuery($sql,
            array($keys),
            array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        return $stmt;
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param array[] ...$keys
     * @return Statement
     */
    public function returnMultiIntArraySqlStmt(EntityManager $em, string $sql, array ...$keys)
    {
        $intParams = [];
        $base = array_reduce($keys, function ($result, $item) use(&$intParams) {
            $result[] = $item;
            array_push($intParams, Connection::PARAM_INT_ARRAY);
            return $result;
        }, []);
        $stmt = $em->getConnection()->executeQuery($sql, $base, $intParams);
        return $stmt;
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param array $orderedParams
     * @return Statement|\Exception
     */
    public function buildStmtFromSql(EntityManager $em, string $sql, array $orderedParams = [])
    {
        try {
            return $this->bindStatementParamValues(
                $em->getConnection()->prepare($sql), $orderedParams);
        } catch (\Exception $exception){
            Log::critical("Attempt to build sql statement $sql returned error: {$exception->getMessage()}");
            return $exception;
        }
    }

    /**
     * @param Statement $stmt
     * @param string $fetchMethod
     * @return mixed|\Exception
     */
    public function executeStatementFetchMethod(Statement $stmt, string $fetchMethod)
    {
        if (!method_exists($stmt, $fetchMethod)){
            $msg = "Method $fetchMethod does not exist in Doctrine\DBAL\Statement";
            Log::warning($msg);
            return new \Exception($msg);
        }
        try {
            if ($fetchMethod !== 'execute'){
                $stmt->execute();
            }
            return $stmt->{$fetchMethod}();
        } catch (\Exception $exception){
            Log::critical("Error executing statement with error: {$exception->getMessage()}");
            return $exception;
        }
    }

    private function bindStatementParamValues(Statement $stmt, array $orderedParams = [])
    {
        if (count($orderedParams) === 0)
            return $stmt;
        $counter = 1;
        each(function ($param) use(&$stmt, &$counter){
            $stmt->bindValue($counter, $param);
            $counter++;
        }, $orderedParams);
        return $stmt;
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param string $fetchMethod
     * @param array $orderedParams
     * @param bool $useIntArr
     * @return mixed|\Exception
     */
    private function buildAndExecuteFromSql(EntityManager $em, string $sql, string $fetchMethod,
                                            array $orderedParams, $useIntArr=false)
    {
        if (!$useIntArr){
            if (($stmt = $this->buildStmtFromSql($em, $sql, $orderedParams) ) instanceof \Exception)
                return $stmt;
            return $this->executeStatementFetchMethod($stmt, $fetchMethod);
        } else {
            return $this->fetchByIntArray($em, $orderedParams, $sql);
        }
    }

    /**
     * @param string $targetStr
     * @param string $method
     * @param string $class
     * @return string
     */
    public function unrecognizableTargetMsg(string $targetStr, string $method, string $class) :string
    {
        return "Unrecognizable target type $targetStr in call to $method in class $class";
    }

    /**
     * @param string $conditional
     * @param string $method
     * @param string $class
     * @return string
     */
    public function unrecognizableConditionMsg(string $conditional, string $method, string $class) :string
    {
        return "Unrecognizable condition variable type $conditional in call to $method in class $class";
    }

    /**
     * @return RepositoryException
     */
    public function getRepoException() : RepositoryException
    {
        if (! $this->repoException instanceof RepositoryException){
            $this->repoException = new RepositoryException();
        }
        return $this->repoException;
    }

}
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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use http\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Doctrine\DBAL\ForwardCompatibility\DriverResultStatement;
use Doctrine\DBAL\ForwardCompatibility\DriverStatement;
use Doctrine\DBAL\ForwardCompatibility\Result;
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
        $results = $stmt->{self::FETCH_ALL_ASSO_MTHD}();
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
            array(\Doctrine\DBAL\ArrayParameterType::INTEGER)
        );
        return $stmt;
    }

    /**
     * @param EntityManager $em
     * @param array $keys
     * @param string $sql
     * @return DriverResultStatement|DriverStatement|Result|string
     */
    public function returnInArraySqlDriver(EntityManager $em, array $keys, string $sql)
    {
        try {
            return $em->getConnection()->executeQuery($sql,
                array($keys),
                array(\Doctrine\DBAL\ArrayParameterType::INTEGER)
            );
        }catch (\Exception $err){
            return $err->getMessage();
        }
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param array[] ...$keys
     * @return DriverStatement|Result|string
     */
    public function returnMultiIntArraySqlStmt(EntityManager $em, string $sql, array ...$keys)
    {
        $intParams = [];
        $base = array_reduce($keys, function ($result, $item) use(&$intParams) {
            $result[] = $item;
            array_push($intParams, \Doctrine\DBAL\ArrayParameterType::INTEGER);
            return $result;
        }, []);
        try {
            return $em->getConnection()->executeQuery($sql, $base, $intParams);
        }catch (\Doctrine\DBAL\Exception $err){
            return $err->getMessage();
        }
    }


    public function buildAndExecuteMultiIntStmt(EntityManager $em, string $sql, string $fetchMethod, array ...$keys)
    {
        $stmt = $this->returnMultiIntArraySqlStmt($em, $sql, ...$keys);
        $results = $stmt;

        if ($fetchMethod != self::EXECUTE_MTHD) {
            $results = $stmt->{$fetchMethod}();
        }

        return $results;
    }

    public function buildAndExecuteIntArrayStmt(EntityManager $em, string $sql, string $fetchMethod, array $inValues) {
        $stmt = $this->returnInArraySqlStmt($em, $inValues, $sql);

        $results = $stmt;

        if ($fetchMethod != self::EXECUTE_MTHD) {
            $results = $stmt->{$fetchMethod}();
        }

        return $results;
    }

    /**
     * @param EntityManager $em
     * @param string $sql
     * @param array $orderedParams
     * @return Statement|\Exception
     */
    public function buildStmtFromSql(EntityManager|EntityManagerInterface $em, string $sql, array $orderedParams = []): Statement|\Exception
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
    public function executeStatementFetchMethod(Statement $stmt, string $fetchMethod):mixed
    {
        if (!method_exists(\Doctrine\DBAL\Result::class, $fetchMethod) && $fetchMethod != self::EXECUTE_MTHD) {
            $msg = "Method $fetchMethod does not exist in Doctrine\DBAL\Statement";
            Log::warning($msg);
            return new \Exception($msg);
        }
        try {
            if ($fetchMethod === self::EXECUTE_MTHD)
                $result =  $stmt->executeQuery([]);
            else
                $result = $stmt->executeQuery()->{$fetchMethod}();
        } catch (\Doctrine\DBAL\Driver\Exception|\Exception  $exception){
            Log::critical("Error executing statement with error: {$exception->getMessage()}");
            return $exception;
        }
        return $result;
    }

    /**
     * @param Statement $stmt
     * @param array $orderedParams
     * @return Statement
     */
    public function bindStatementParamValues(Statement $stmt, array $orderedParams = []):Statement
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
     * @param EntityManager|EntityManagerInterface $em
     * @param string $sql
     * @param string $fetchMethod
     * @param array $orderedParams
     * @param bool $useIntArr
     * @return mixed|\Exception
     */
    private function buildAndExecuteFromSql(
        EntityManager|EntityManagerInterface $em, 
        string $sql, 
        string $fetchMethod,
        array $orderedParams = [],
        bool $useIntArr = false
    ):mixed {
        if (!$useIntArr){
            if (($stmt = $this->buildStmtFromSql($em, $sql, $orderedParams) ) instanceof \Exception)
                return $stmt;
            return $this->executeStatementFetchMethod($stmt, $fetchMethod);
        } else {
            return $this->fetchByIntArray($em, $orderedParams, $sql);
        }
    }

    private function executeProcedure(array $params, string $procedure)
    {
        return json_decode(
            json_encode(DB::select($procedure, $params)),
            true
        );
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
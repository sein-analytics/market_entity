<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 10:45 AM
 */

namespace App\Service;
use Doctrine\DBAL\Driver\Statement;
use function Lambdish\phunctional\{each};
use Doctrine\ORM\Query;

/**
 * Trait FetchMapperTrait
 * @package App\Service
 */
trait FetchMapperTrait
{

    /**
     * @param array $requestedIds
     * @param array $results
     * @param string $fetcherKey
     * @return array
     */
    public function mapRequestIdsToResults(array $requestedIds, array $results, string $fetcherKey, bool $unique = false)
    {
        $data = [];
        foreach ($requestedIds as $requestedId)
        {
            $data[$requestedId] = [];
            foreach ($results as $int => $result)
            {
                if($result[$fetcherKey] == $requestedId)
                {
                    if ($unique) {
                        $data[$requestedId] = $result;
                    } else {
                        array_push($data[$requestedId], $result);
                        unset($results[$int]);
                    }
                }
            }
        }
        return $data;
    }

    public function completeIdFetchQuery(Statement $stmt)
    {
        try {
            $stmt->execute();
            $result = $stmt->fetchAllAssociative();
        }catch (\Exception $exception){
            return false;
        }
        if (count($result) > 0){
            return $this->flattenResultArrayByKey($result, 'id');
        }
        return false;
    }

    /**
     * @param array $hydration
     * @param $key
     * @return array
     */
    public function flattenResultArrayByKey(array $hydration, $key, $isIntVar=true):array
    {
        $flat = [];
        $pos = strripos($key, 'id');
        foreach ($hydration as $dataPoint){
            if($pos !== false && $isIntVar){
                $flat[] = (int)$dataPoint[$key];
            }else{
                $flat[] = $dataPoint[$key];
            }
        }
        return $flat;
    }

    /**
     * @param array $statusArray
     * @return array
     */
    public function idToStatusMapper(array $statusArray)
    {
        $base = [];
        foreach ($statusArray as $int => $status){
            $base[$status['id']] = $status['status'];
        }
        return $base;
    }

    public function flattenByKeyValue(array $results, string $key, string $value,
                                      \Closure $keyFunc, \Closure $valueFunc):array
    {
        $flatArray = [];
        if (count($results) > 0) {
            each(function ($result) use(&$flatArray, $keyFunc, $valueFunc, $key, $value) {
                if (array_key_exists($key, $result)
                    && array_key_exists($value, $result)){
                    $flatArray[$keyFunc($result[$key])] = $valueFunc($result[$value]);
                }
            }, $results);
        }
        return $flatArray;
    }

    public function dbValueToIntClosure():\Closure {
        return function($dbValue) {
            return (int)$dbValue;
        };
    }

    public function dbValueRawCloser():\Closure {
        return function ($dbValue) {
            return $dbValue;
        };
    }

    public function dbValueSubStringFromCharClosure($char):\Closure {
        return function ($dbValue) use($char) {
            if (($pos = strripos($dbValue, $char)) === false)
                return $dbValue;
            return substr($dbValue, 0, $pos);
        };
    }

}
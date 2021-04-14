<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 10:45 AM
 */

namespace App\Service;
use Doctrine\DBAL\Driver\Statement;
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
    public function mapRequestIdsToResults(array $requestedIds, array $results, string $fetcherKey)
    {
        $data = [];
        foreach ($requestedIds as $requestedId)
        {
            $data[$requestedId] = [];
            foreach ($results as $int => $result)
            {
                if($result[$fetcherKey] == $requestedId)
                {
                    array_push($data[$requestedId], $result);
                    unset($results[$int]);
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
    public function flattenResultArrayByKey(array $hydration, $key, $isIntVar=true)
    {
        $flat = [];
        $pos = strripos($key, 'id');
        foreach ($hydration as $dataPoint){
            if($pos !== false && $isIntVar){
                array_push($flat, (int)$dataPoint[$key]);
            }else{
                array_push($flat, $dataPoint[$key]);
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

}
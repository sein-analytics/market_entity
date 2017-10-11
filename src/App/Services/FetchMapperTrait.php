<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/11/17
 * Time: 10:45 AM
 */

namespace App\Service;

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

    public function flattenResultArrayByKey(array $hydration, $key)
    {
        $flat = [];
        foreach ($hydration as $dataPoint){
            array_push($flat, $dataPoint[$key]);
        }
        return $flat;
    }

}
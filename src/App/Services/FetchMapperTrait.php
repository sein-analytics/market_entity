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
        $stmt->execute()
;        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        if (count($result) > 0){
            return $this->flattenResultArrayByKey($result, 'id');
        }
        return false;
    }

    public function flattenResultArrayByKey(array $hydration, $key)
    {
        $flat = [];
        foreach ($hydration as $dataPoint){
            if($key == 'id'){
                array_push($flat, (int)$dataPoint[$key]);
            }else{
                array_push($flat, $dataPoint[$key]);
            }
        }
        return $flat;
    }

}
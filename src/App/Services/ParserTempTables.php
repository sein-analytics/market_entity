<?php

/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 08/22/25
 * Time: 2:45 PM
 */

namespace App\Service;

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

class ParserTempTables
{
    const RESULTS_DB_PROP_KEY = 'dbPropArray';

    const RESULTS_DB_NAME_KEY = 'dbName';

    /**
     * @param EntityManager|EntityManagerInterface $em
     * @param string $dealName
     * @param array $nulls
     * @return void
     */
    public function createOmittedNullTable(EntityManager|EntityManagerInterface $em, string $dealName, string $parserName, array $nulls):void
    {
        $connection = $em->getConnection();
        $name = $dealName . "_" . $this->randomDateAppend() . '_' . $parserName;
        $sql =  "CREATE TEMPORARY TABLE $name (
            id INT PRIMARY KEY,
            col_name JSON
        )";
    }

    /**
     * @return string
     */
    public function randomDateAppend(): string
    {
        $randDate = new \DateTime();
        $randDate->setTime(mt_rand(0, 23), mt_rand(0, 59));
        return $randDate->format('Y-m-d H:i');
    }

    public function columnsByResultsPropsArray(array $results):array
    {
        $colNames = [];
        foreach ($results[array_key_first($results)] as $key => $data){
            if (array_key_exists(self::RESULTS_DB_PROP_KEY, $data)
                && is_array($data[self::RESULTS_DB_PROP_KEY])
                && array_key_exists(self::RESULTS_DB_NAME_KEY, $data[self::RESULTS_DB_PROP_KEY])){
                $colNames[] = $data[self::RESULTS_DB_PROP_KEY][self::RESULTS_DB_NAME_KEY];
            }
        }
        return $colNames;
    }

}

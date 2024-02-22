<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycType extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $fetchKycTypesSql = "SELECT * FROM KycType;";

    public function fetchKycTypes():mixed
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchKycTypesSql,
            self::FETCH_ALL_ASSO_MTHD,
            []
        );
        $keyResults = [];
        foreach($results as $result) {
            $result['documents'] = [];
            $keyResults[$result[self::QUERY_JUST_ID]] = $result;
        }
        return $keyResults;
    }

}
<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycType extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $fetchKycTypesSql = "SELECT * FROM KycType";

    public function fetchKycTypes(array $noFetchIds = []):mixed
    {
        $baseQry = $this->fetchKycTypesSql;

        if (count($noFetchIds) > 0) {
            $baseQry = $baseQry .
                " WHERE ID NOT IN (" . implode(',', $noFetchIds) . ")";
        }

        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $baseQry,
            self::FETCH_ALL_ASSO_MTHD,
            []
        );
        return $results;
    }

}
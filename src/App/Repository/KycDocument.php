<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocument extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertKycDocumentSql = "INSERT INTO KycDocument VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateKycDocumentStatusSql = "UPDATE KycDocument SET contract_status_id=? WHERE id=?";

    private string $fetchUserKycDocumentsByIssuerSql = "SELECT * FROM KycDocument WHERE user_id=? AND community_issuer_id=? AND community_user_id=?";

    public function insertNewKycDocument(array $params):mixed
    {
        if (array_key_exists(self::DC_QRY_ID_KEY, $params))
        unset($params[self::DC_QRY_ID_KEY]);

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertKycDocumentSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateKycDocumentStatus(int $statusId, int $documentId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateKycDocumentStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $documentId]
        ); 
    }

    public function fetchUserKycDocumentsByIssuer(int $userId, int $communityId, int $communityUserId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchUserKycDocumentsByIssuerSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userId, $communityId, $communityUserId]
        );
    }

}
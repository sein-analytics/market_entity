<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocument extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertKycDocumentSql = "INSERT INTO KycDocument VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateKycDocumentStatusSql = "UPDATE KycDocument SET contract_status_id=? WHERE id=?";

    private string $updateKycDocumentSignIds = "UPDATE KycDocument SET sender_signature=?, receiver_signature=?, contract_status_id=1 WHERE id=?;";

    private string $fetchUserKycDocumentsByIssuerSql = "SELECT * FROM KycDocument WHERE user_id=? AND community_issuer_id=? AND community_user_id=?";

    private string $fetchKycDocumentBySignatureIdSql = "SELECT * FROM KycDocument WHERE sender_signature=? OR receiver_signature=?";

    private string $insertIntoIssuerKycDocSql = "INSERT INTO issuer_kyc_document (`issuer_id`, `kyc_document_id`) VALUES";

    private string $deleteIssuerKycDocsAccessSql = "DELETE FROM issuer_kyc_document WHERE issuer_id=? AND kyc_document_id IN (?)";

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

    public function fetchUserKycDocumentsByIssuer(int $userId, int $issuerId, int $communityUserId, int $communityIssuerId, int $assetTypeId):mixed
    {
        return $this->executeProcedure([$userId, $issuerId, $communityUserId, $communityIssuerId, $assetTypeId],
            self::$callKycDocumentsByUserAndIssuer);
    }

    public function updateKycDocumentSignIds(string $senderSignId, string $receiverSignId, string $kycDocId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateKycDocumentSignIds,
            self::EXECUTE_MTHD,
            [$senderSignId, $receiverSignId, $kycDocId]
        ); 
    }

    public function fetchKycDocumentBySignatureId(string $signatureId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchKycDocumentBySignatureIdSql,
            self::FETCH_ASSO_MTHD,
            [$signatureId, $signatureId]
        );
    }

    public function addMultiIssuerKycDocAccess(int $issuerId, array $kycDocsIds)
    {
        $base = $this->insertIntoIssuerKycDocSql;
        $insertCount = 0;
        foreach ($kycDocsIds as $kycDocId) {
            $insertCount++;
            $base = $base . PHP_EOL .
                '(' . $issuerId  . ',' . $kycDocId . ')'.
                    ($insertCount == count($kycDocsIds) ? ';' : ',');
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }

    public function deleteIssuerKycDocAccess(int $issuerId, array $kycDocsIds)
    {
        $ids = implode(',', $kycDocsIds);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteIssuerKycDocsAccessSql,
            self::EXECUTE_MTHD,
            [$issuerId, $ids]
        );
    }

}
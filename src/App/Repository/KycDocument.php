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

    private string $fetchKycDocsIdsByIssuerAndAssetSql = "SELECT id FROM KycDocument WHERE issuer_id=? AND (community_issuer_id=? OR community_issuer_id IS NULL) AND (kyc_asset_type_id=? OR kyc_asset_type_id IS NULL)";

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
        $stmt = $this->returnMultiIntArraySqlStmt(
            $this->getEntityManager(),
            $this->deleteIssuerKycDocsAccessSql,
            [$issuerId],
            $kycDocsIds
        );
        $stmt->execute();
    }

    public function fetchKycDocsIdsByIssuerAndAsset(int $issuerId, int $communityIssuerId, int $assetTypeId)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchKycDocsIdsByIssuerAndAssetSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$issuerId, $communityIssuerId, $assetTypeId]
        );
        $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID, false);
        return $results;
    }

    public function fetchIssuersByAssetAndKycDocsRequests(int $issuerId, int $assetTypeId)
    {
        $sql = "SELECT DISTINCT issuers.id AS issuerId, issuers.issuer_name AS issuerName FROM Issuer AS issuers"
            . " INNER JOIN KycDocRequest AS requests ON issuers.id = requests.community_issuer_id"
                . " WHERE requests.issuer_id=? AND (requests.kyc_asset_type_id=? OR requests.kyc_asset_type_id IS NULL)";
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::FETCH_ALL_ASSO_MTHD,
            [$issuerId, $assetTypeId]
        );
        return $results;
    }

    public function fetchAllowedKycDocumentsIds(int $issuerId, int $communityIssuerId, int $assetTypeId):mixed
    {
        $results = $this->executeProcedure([$issuerId, $communityIssuerId, $assetTypeId],
            self::$callFetchAllowedKycDocumentsIds);
        $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID, false);
        return $results;
    }

    public function fetchIssuersKycDocumentsAccess(int $issuerId, int $assetTypeId):mixed
    {
        $results = $this->executeProcedure([$issuerId, $assetTypeId],
            self::$callFetchIssuersKycDocumentsAccess);
        return $results;
    }

    public function fetchKycDocumentByIssuerAndUser(int $userId, int $issuerId, int $communityUserId, int $communityIssuerId, int $assetTypeId):mixed
    {
        $results = $this->executeProcedure(
            [$userId, $issuerId, $communityUserId, $communityIssuerId, $assetTypeId],
            self::$callFetchKycDocumentByIssuerAndUser
        );

        return $results;
    }

    public function fetchUserKycDocuments(int $userId, int $issuerId, int $assetTypeId):mixed
    {
        $results = $this->executeProcedure(
            [$userId, $issuerId, $assetTypeId],
            self::$callFetchUserKycDocuments
        );

        return $results;
    }

}
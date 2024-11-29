<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocument extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertKycDocumentSql = "INSERT INTO KycDocument VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateKycDocumentStatusSql = "UPDATE KycDocument SET contract_status_id=? WHERE id=?";

    private string $updateKycDocumentSignIds = "UPDATE KycDocument SET sender_signature=?, receiver_signature=?, contract_status_id=1 WHERE id=?;";

    private string $fetchUserKycDocumentsByIssuerSql = "SELECT * FROM KycDocument WHERE user_id=? AND community_issuer_id=? AND community_user_id=?";

    private string $fetchKycDocumentBySignatureIdSql = "SELECT * FROM KycDocument WHERE sender_signature=? OR receiver_signature=?";

    private string $insertIntoIssuerKycDocSql = "INSERT INTO issuer_kyc_document (`issuer_id`, `kyc_document_id`) VALUES";

    private string $deleteIssuerKycDocsAccessSql = "DELETE FROM issuer_kyc_document WHERE issuer_id=? AND kyc_document_id IN (?)";

    private string $fetchKycDocsIdsByIssuerAndAssetSql = "SELECT id FROM KycDocument WHERE issuer_id=? AND (community_issuer_id=? OR community_issuer_id IS NULL) AND (kyc_asset_type_id=? OR kyc_asset_type_id IS NULL)";

    private string $updateContractSignatureIdSql = "UPDATE KycDocument SET contract_signature_id=? WHERE id=?";

    private string $fetchDocumentByTypeAndUsers = "SELECT * FROM KycDocument WHERE kyc_type_id=? AND user_id=? AND community_user_id=?";

    private string $fetchDocumentByAssetIdSql = "SELECT * FROM KycDocument WHERE asset_id=?";

    private string $fetchKycDocumentByIdSql = "SELECT * FROM KycDocument WHERE id=?";

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

    public function addMultiKycDocIssuersAccess(int $kycDocId, array $issuersIds)
    {
        $base = $this->insertIntoIssuerKycDocSql;
        $insertCount = 0;
        foreach ($issuersIds as $issuerId) {
            $insertCount++;
            $base = $base . PHP_EOL .
                '(' . $issuerId  . ',' . $kycDocId . ')'.
                    ($insertCount == count($issuersIds) ? ';' : ',');
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

    public function fetchKycDocsIdsByIssuerAndAssetAndType(int $issuerId, ?int $assetTypeId, int $kycTypeId)
    {
        $baseQry = "SELECT id FROM KycDocument WHERE issuer_id=? AND community_issuer_id IS NULL";
        $baseQryParams = [$issuerId];

        if (is_null($assetTypeId) || $kycTypeId == self::KYC_TYPE_GENERAL_ID) {
            $baseQry = $baseQry . " AND kyc_asset_type_id IS NULL";
        } else {
            $baseQry = $baseQry . " AND kyc_asset_type_id=?";
            $baseQryParams[] = $assetTypeId;
        }

        if ($kycTypeId != self::KYC_TYPE_GENERAL_ID) {
            $baseQry = $baseQry . " AND kyc_type_id=?";
            $baseQryParams[] = $kycTypeId;
        }

        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $baseQry,
            self::FETCH_ALL_ASSO_MTHD,
            $baseQryParams
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

    public function fetchAllowedKycDocumentsIds(int $issuerId, int $communityIssuerId, int $assetTypeId, int $kycTypeId):mixed
    {
        $results = $this->executeProcedure([$issuerId, $communityIssuerId, $assetTypeId, $kycTypeId],
            self::$callFetchAllowedKycDocumentsIds);
        $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID, false);
        return $results;
    }

    public function fetchAllowedGrantAccessIssuersIds(int $issuerId, int $assetTypeId, int $kycTypeId):mixed
    {
        $results = $this->executeProcedure([$issuerId, $assetTypeId, $kycTypeId],
            self::$callFetchAllowedGrantAccessIssuersIds);
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

    public function updateContractSignature(int $contractSignId, int $kycDocId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateContractSignatureIdSql,
            self::EXECUTE_MTHD,
            [$contractSignId, $kycDocId]
        ); 
    }

    public function fetchDocumentByTypeAndUsers(int $typeId, int $userId, $communityUserId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchDocumentByTypeAndUsers,
            self::FETCH_ASSO_MTHD,
            [$typeId, $userId, $communityUserId]
        );
    }

    public function fetchDocumentByAssetId(string $assetId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchDocumentByAssetIdSql,
            self::FETCH_ASSO_MTHD,
            [$assetId]
        );
    }

    public function fetchIssuerDocumentsCountByAssetAndType(int $issuerId, ?int $kycTypeId, ?int $assetTypeId)
    {
        $query = "SELECT COUNT(id) AS count FROM KycDocument WHERE issuer_id=? AND community_issuer_id IS NULL";
        $params = [$issuerId];

        if (!is_null($assetTypeId)) {
            $query = $query . " AND kyc_asset_type_id=?";
            $params[] =  $assetTypeId;
        } else {
            $query = $query . " AND kyc_asset_type_id IS NULL";
        }

        if (!is_null($kycTypeId)) {
            $query = $query . " AND kyc_type_id=?";
            $params[] =  $kycTypeId;
        }

        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::FETCH_ASSO_MTHD,
            $params
        );

        return $results[self::COUNT_DB_KEY];
    }

    public function updateKycDocumentById(int $kycDocId, array $columnsValues)
    {
        $query = "UPDATE KycDocument SET ";
        $values = [];
        $count = 0;

        foreach($columnsValues as $key => $value) {
            $count++;
            $columnToSet = "$key=?" . ($count == count($columnsValues)
                ? " " : ", ");
            $query = $query . $columnToSet;
            $values[] = $value;
        }

        $query = $query . "WHERE id=?";
        $values[] = $kycDocId;

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::EXECUTE_MTHD,
            $values
        );
    }

    public function fetchKycDocumentById(int $kycDocId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchKycDocumentByIdSql,
            self::FETCH_ASSO_MTHD,
            [$kycDocId]
        );
    }

    public function fetchKycDocumentDetails(int $kycDocumentId, int $userId)
    {
        return $this->executeProcedure([$kycDocumentId, $userId], self::$callFetchKycDocumentDetails);
    }

}
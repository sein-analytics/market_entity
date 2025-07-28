<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocRequest extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertMultiKycDocRequestsSql = "INSERT INTO KycDocRequest " .
        "(`community_user_id`, `community_issuer_id`, `user_id`, `issuer_id`, `kyc_type_id`, `kyc_asset_type_id`, `description`, `date`, `bid_id`, `deal_id`, `kyc_doc_request_status_id`)" .
        " VALUES ";

    private string $insertKycDocRequestSql = "INSERT INTO KycDocRequest VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $deleteKycDocRequestByIdSql = "DELETE FROM KycDocRequest WHERE id=?";

    private string $fetchCommIssuerRequestsByTypeAndAssetSql =
        "SELECT * FROM KycDocRequest WHERE issuer_id=? AND community_issuer_id=? AND kyc_type_id=?";

    private string $deleteIssuerRequestsByTypeAndAssetSql = "DELETE FROM KycDocRequest WHERE issuer_id=? AND kyc_type_id=?";

    private string $deleteCommUserRequestSql = "DELETE FROM KycDocRequest WHERE user_id=? AND community_user_id=? AND kyc_type_id=?";

    private string $callFetchUserDealsAccessRequests = 'call FetchUserDealsAccessRequests(:userId, :assetTypeId)';

    private string $fetchNonDealRequestByTypeAndUsers = "SELECT * FROM KycDocRequest WHERE kyc_type_id=? AND user_id=? AND community_user_id=? AND deal_id IS NULL";

    private string $updateDocRequestStatusSql = "UPDATE KycDocRequest SET kyc_doc_request_status_id=? WHERE id=?";

    public function insertMultiKycDocRequests(
        int $communityIssuerId,
        int $communityUserId,
        int $assetTypeId,
        int $kycTypeId,
        string $description,
        string $date,
        array $bids
    ) {
        $base = $this->insertMultiKycDocRequestsSql;
        $insertCount = 0;
        foreach ($bids as $bid) {
            $insertCount++;
            $base = $base . PHP_EOL .
                '(' .
                $communityUserId . ',' . $communityIssuerId . ',' .
                $bid['userId'] . ',' . $bid['issuerId'] . ',' . $kycTypeId . ',' .
                $assetTypeId . ',' . "'" . $description . "'" . ',' .  "'" . $date . "'" . ',' . 
                $bid['bidId'] . ',' . $bid['dealId'] . ',' . self::KR_STATUS_OPEN_ID . ')' . ($insertCount == count($bids) ? ';' : ',');
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }

    public function insertNewKycDocRequest(array $params)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertKycDocRequestSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function deleteKycDocRequestById(int $kycDocRequestId) 
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteKycDocRequestByIdSql,
            self::EXECUTE_MTHD,
            [$kycDocRequestId]
        );
    }

    public function fetchCommIssuerRequestsByTypeAndAsset(int $issuerId, int $communityIssuerId, int $kycTypeId, ?int $assetTypeId) 
    {
        $fetchCommIssuerRequestsByTypeAndAssetSql = $this->fetchCommIssuerRequestsByTypeAndAssetSql;
        $queryParams = [$issuerId, $communityIssuerId, $kycTypeId];

        if (is_null($assetTypeId)) {
            $fetchCommIssuerRequestsByTypeAndAssetSql =
                $fetchCommIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id IS NULL";
        } else {
            $fetchCommIssuerRequestsByTypeAndAssetSql = 
                $fetchCommIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id=?";
            $queryParams[] = $assetTypeId;
        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $fetchCommIssuerRequestsByTypeAndAssetSql,
            self::FETCH_ALL_ASSO_MTHD,
            $queryParams
        );
    }

    public function fetchCommIssuerOpenRequestsByTypeAndAsset(
        int $issuerId,
        int $communityIssuerId,
        int $kycTypeId,
        ?int $assetTypeId,
        array $statusIds = []
    ) {
        $fetchCommIssuerRequestsByTypeAndAssetSql = $this->fetchCommIssuerRequestsByTypeAndAssetSql;
        $queryParams = [$issuerId, $communityIssuerId, $kycTypeId];

        if (is_null($assetTypeId)) {
            $fetchCommIssuerRequestsByTypeAndAssetSql =
                $fetchCommIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id IS NULL";
        } else {
            $fetchCommIssuerRequestsByTypeAndAssetSql = 
                $fetchCommIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id=?";
            $queryParams[] = $assetTypeId;
        }

        $fetchCommIssuerRequestsByTypeAndAssetSql =
            $fetchCommIssuerRequestsByTypeAndAssetSql . " AND kyc_doc_request_status_id" .
                (
                    count($statusIds) > 0
                    ? " IN" . " (" . implode(',', $statusIds) . ")"
                    : "=" . self::KR_STATUS_OPEN_ID
                );

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $fetchCommIssuerRequestsByTypeAndAssetSql,
            self::FETCH_ALL_ASSO_MTHD,
            $queryParams
        );
    }

    public function deleteIssuerRequestsByTypeAndAsset(int $issuerId, int $kycTypeId, ?int $assetTypeId)
    {
        $deleteIssuerRequestsByTypeAndAssetSql = $this->deleteIssuerRequestsByTypeAndAssetSql;
        $queryParams = [$issuerId, $kycTypeId];

        if (is_null($assetTypeId)) {
            $deleteIssuerRequestsByTypeAndAssetSql =
                $deleteIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id IS NULL";
        } else {
            $deleteIssuerRequestsByTypeAndAssetSql =
                $deleteIssuerRequestsByTypeAndAssetSql . " AND kyc_asset_type_id=?";
            $queryParams[] = $assetTypeId;
        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $deleteIssuerRequestsByTypeAndAssetSql,
            self::EXECUTE_MTHD,
            $queryParams
        );
    }

    public function deleteCommUserRequestSql(int $userId, int $communityUserId, int $kycTypeId, ?int $assetTypeId, ?int $dealId)
    {
        $deleteCommUserRequestSql = $this->deleteCommUserRequestSql;
        $queryParams = [$userId, $communityUserId, $kycTypeId];

        if (is_null($assetTypeId)) {
            $deleteCommUserRequestSql = $deleteCommUserRequestSql . " AND kyc_asset_type_id IS NULL";
        } elseif(!is_null($dealId)) {
            $deleteCommUserRequestSql =
                $deleteCommUserRequestSql . " AND kyc_asset_type_id=? AND deal_id=?";
            $queryParams = array_merge($queryParams, [$assetTypeId, $dealId]);
        } else {
            $deleteCommUserRequestSql = $deleteCommUserRequestSql . " AND kyc_asset_type_id=?";
            $queryParams[] = $assetTypeId;
        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $deleteCommUserRequestSql,
            self::EXECUTE_MTHD,
            $queryParams
        );
    }

    public function fetchUserDealsAccessRequests(int $userId, int $assetTypeId):mixed
    {
        $results = $this->executeProcedure(
            [$userId, $assetTypeId],
            $this->callFetchUserDealsAccessRequests
        );

        return $results;
    }

    public function fetchNonDealRequestByTypeAndUsers(int $typeId, int $userId, $communityUserId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchNonDealRequestByTypeAndUsers,
            self::FETCH_ASSO_MTHD,
            [$typeId, $userId, $communityUserId]
        );
    }

    public function fetchUsersOpenIndividualRequests(
        int $userId, 
        int $communityUserId, 
        ?int $assetTypeId, 
        ?int $typeId,
        ?int $dealId,
        ?int $bidId
    ) {
        $query = "SELECT * FROM KycDocRequest WHERE user_id=? AND community_user_id=? AND kyc_doc_request_status_id=?";
        $params = [$userId, $communityUserId, self::KR_STATUS_OPEN_ID];

        $queryConditionsMap = [
            self::KD_QRY_ASSET_TYPE_ID => $assetTypeId,
            self::KD_QRY_KYC_TYPE_KEY => $typeId,
            'deal_id' => $dealId,
            'bid_id' => $bidId
        ];

        foreach($queryConditionsMap as $field => $value) {

            if (is_null($value)) {
                $query .= " AND $field IS NULL";
            } else {
                $query .= " AND $field=?";
                $params[] = $value;
            }

        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::FETCH_ASSO_MTHD,
            $params
        );
    }

    public function updateDocRequestStatus(int $kycDocRequestId, int $statusId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateDocRequestStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $kycDocRequestId]
        );
    }

    public function fetchIssuersRequestsCountByAssetAndType(int $issuerId, int $communityIssuerId, int $typeId, ?int $assetTypeId)
    {
        $query = "SELECT COUNT(id) AS count FROM KycDocRequest WHERE issuer_id=? AND community_issuer_id=? AND kyc_type_id=?";
        $params = [$issuerId, $communityIssuerId, $typeId];

        if (!is_null($assetTypeId)) {
            $query = $query . " AND kyc_asset_type_id=?";
            $params[] =  $assetTypeId;
        } else {
            $query = $query . " AND kyc_asset_type_id IS NULL";
        }

        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::FETCH_ASSO_MTHD,
            $params
        );

        return $results[self::COUNT_DB_KEY];
    }

    public function fetchLastInsertedActiveRequestId(int $communityUserId, int $userId, array $columnsValues = [], bool $noFileAssociation = false)
    {
        $query = "SELECT requests.id FROM KycDocRequest requests ";
        $values = [$communityUserId, $userId];

        if ($noFileAssociation) {
            $query = 
                $query . "LEFT JOIN KycDocument AS kycDoc ON kycDoc.kyc_doc_request_id = requests.id " .
                "LEFT JOIN DealContract AS dealFile ON dealFile.kyc_doc_request_id = requests.id ";
        }

        $query = $query . "WHERE requests.kyc_doc_request_status_id = 1 AND requests.community_user_id=? AND requests.user_id=? " .
            ($noFileAssociation ? "AND kycDoc.id IS NULL AND dealFile.id IS NULL " : " ");

        foreach($columnsValues as $key => $value) {
            $query = $query . "AND requests.$key" . (!is_null($value) ? "=? " : " IS NULL ");

            if (!is_null($value))
                $values[] = $value;
        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query . " ORDER BY id DESC",
            self::FETCH_ASSO_MTHD,
            $values
        );
    }

}

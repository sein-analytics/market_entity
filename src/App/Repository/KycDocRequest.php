<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocRequest extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertMultiKycDocRequestsSql = "INSERT INTO KycDocRequest " .
        "(`community_user_id`, `community_issuer_id`, `user_id`, `issuer_id`, `kyc_type_id`, `kyc_asset_type_id`, `description`, `date`, `bid_id`, `deal_id`)" .
        " VALUES ";

    private string $insertKycDocRequestSql = "INSERT INTO KycDocRequest VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $deleteKycDocRequestByIdSql = "DELETE FROM KycDocRequest WHERE id=?";

    private string $fetchCommIssuerRequestsByTypeAndAssetSql =
        "SELECT * FROM KycDocRequest WHERE issuer_id=? AND community_issuer_id=? AND kyc_type_id=?";

    private string $deleteIssuerRequestsByTypeAndAssetSql = "DELETE FROM KycDocRequest WHERE issuer_id=? AND kyc_type_id=?";

    private string $deleteCommUserRequestSql = "DELETE FROM KycDocRequest WHERE user_id=? AND community_user_id=? AND kyc_type_id=?";

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
                $bid['bidId'] . ',' . $bid['dealId'] . ')' . ($insertCount == count($bids) ? ';' : ',');
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

}

<?php

namespace App\Repository;

use App\Repository\KycDocument\KycDocumentAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class KycDocRequest extends KycDocumentAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertMultiKycDocRequestsSql = "INSERT INTO KycDocRequest " .
        "(`community_user_id`, `community_issuer_id`, `user_id`, `issuer_id`, `kyc_type_id`, `kyc_asset_type_id`, `description`, `date`, `bid_id`)" .
        " VALUES ";

    private string $deleteKycDocRequestByIdSql = "DELETE FROM KycDocRequest WHERE id=?";

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
                $assetTypeId . ',' . "'" . $description . "'" . ',' .  "'" . $date . "'" . ',' . $bid['bidId'] .
                ')' . ($insertCount == count($bids) ? ';' : ',');
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
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

}

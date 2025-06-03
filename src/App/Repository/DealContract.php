<?php

namespace App\Repository;

use App\Repository\DealContract\DealContractAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class DealContract extends DealContractAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertDealContractSql = "INSERT INTO DealContract VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateDealContractStatusSql = "UPDATE DealContract SET contract_status_id=? WHERE id=?";

    private string $fetchDealContractByIdSql = "SELECT * FROM DealContract WHERE id=?";

    private string $fetchDocumentByAssetIdSql = "SELECT * FROM DealContract WHERE asset_id=?";

    private string $deleteFileByIdSql = "DELETE FROM DealContract WHERE id=?";

    public function insertNewDealContract(array $params):mixed
    {
        if (array_key_exists(self::DC_QRY_ID_KEY, $params))
        unset($params[self::DC_QRY_ID_KEY]);

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertDealContractSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateDealContractById(int $dealContractId, array $columnsValues)
    {
        $query = "UPDATE DealContract SET ";
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
        $values[] = $dealContractId;

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::EXECUTE_MTHD,
            $values
        );
    }

    public function updateContractStatus(int $statusId, int $contractId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateDealContractStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $contractId]
        ); 
    }

    public function fetchDealContractById(int $dealContractId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchDealContractByIdSql,
            self::FETCH_ASSO_MTHD,
            [$dealContractId]
        );
    }

    public function fetchDealContractByProps(
        int $dealId, 
        int $docTypeId, 
        int $userId, 
        int $communityUserId,
        ?int $bidId
    ) {
        $query = 
            "SELECT * FROM DealContract WHERE deal_id=? AND doc_type_id=? " .
                "AND user_id=? AND community_user_id=?";
        $params = [$dealId, $docTypeId, $userId, $communityUserId];

        if (!is_null($bidId)) {
            $query = $query . " AND bid_id=?";
            $params[] = $bidId;
        } else {
            $query = $query . " AND bid_id IS NULL";
        }

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::FETCH_ASSO_MTHD,
            $params
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
 
    public function deleteFileById(int $dealContractId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteFileByIdSql,
            self::EXECUTE_MTHD,
            [$dealContractId]
        );
    }

}
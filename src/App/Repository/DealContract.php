<?php

namespace App\Repository;

use App\Repository\DealContract\DealContractAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;

class DealContract extends DealContractAbstract
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertDealContractSql = "INSERT INTO DealContract VALUE (null, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateDealContractStatusSql = "UPDATE DealContract SET contract_status_id=? WHERE id=?";

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

    public function updateContractStatus(int $statusId, int $contractId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateDealContractStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $contractId]
        ); 
    }

}
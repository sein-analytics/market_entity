<?php

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityRepository;

class ContractSignature extends EntityRepository implements DbalStatementInterface
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertContractSignatureSql = "INSERT INTO ContractSignature VALUE (null, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateContractSignatureStatusSql = "UPDATE ContractSignature SET contract_status_id=? WHERE id=?";

    private string $fetchIdFromSignIdSql = "SELECT id FROM ContractSignature WHERE signature_id=?";

    public function insertNewContractSignature(array $params):mixed
    {
        if (array_key_exists(self::QUERY_JUST_ID, $params))
        unset($params[self::QUERY_JUST_ID]);

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertContractSignatureSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateContractSignatureStatus(int $statusId, int $id):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateContractSignatureStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $id]
        );
    }

    public function fetchContractStatusIdBySignId(string $signatureId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchIdFromSignIdSql,
            self::FETCH_NUMERIC_MTHD,
            [$signatureId]
        );
    }

}
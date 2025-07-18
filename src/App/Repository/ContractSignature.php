<?php

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityRepository;
use App\Repository\ContractSignature\ContractSignatureInterface;

class ContractSignature extends EntityRepository 
    implements DbalStatementInterface, ContractSignatureInterface
{

    use FetchMapperTrait, FetchingTrait;

    private string $insertContractSignatureSql = "INSERT INTO ContractSignature VALUE (null, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateContractSignatureStatusSql = "UPDATE ContractSignature SET contract_status_id=? WHERE id=?";

    private string $fetchIdFromSignIdSql = "SELECT id FROM ContractSignature WHERE signature_id=?";

    private string $deleteContractSignatureByIdSql = "DELETE FROM ContractSignature WHERE id=?";

    private string $fetchContractSignatureBySignIdSql = "SELECT * FROM ContractSignature WHERE signature_id=?";

    private string $fetchContractSignatureByIdSql = "SELECT * FROM ContractSignature WHERE id=?";

    private string $fetchContractSignatureByPublicIdSql = "SELECT * FROM ContractSignature WHERE public_id=?";

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

    public function fetchContractSignatureBySignId(string $signatureId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchContractSignatureBySignIdSql,
            self::FETCH_ASSO_MTHD,
            [$signatureId]
        );
    }

    public function fetchContractSignatureByPublicId(string $publicId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchContractSignatureByPublicIdSql,
            self::FETCH_ASSO_MTHD,
            [$publicId]
        );
    }

    public function fetchContractSignatureById(int $contractSignatureId)
    {
        $sql =
            'SELECT contractSign.*, sender.issuer_id AS senderIssuerId, receiver.issuer_id AS receiverIssuerId '.
                'FROM ContractSignature AS contractSign '.
                'LEFT JOIN MarketUser AS sender ON sender.id = sender_id '.
                'LEFT JOIN MarketUser AS receiver ON receiver.id = receiver_id '.
                'WHERE contractSign.id=?';

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::FETCH_ASSO_MTHD,
            [$contractSignatureId]
        );
    }

    public function deleteContractSignatureById(int $contractSignatureId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteContractSignatureByIdSql,
            self::EXECUTE_MTHD,
            [$contractSignatureId]
        );
    }

}
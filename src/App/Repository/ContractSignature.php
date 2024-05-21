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

}
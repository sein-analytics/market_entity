<?php

namespace App\Repository;

use App\Repository\DealFile\DocAccessInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use function Lambdish\Phunctional\each;

class DocAccess extends EntityRepository
    implements DocAccessInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $insertDocAccessSql = "INSERT INTO DocAccess VALUE (null, ?, ?, ?)";

    private string $updateDocAccessUserSql = "UPDATE DocAccess SET user_id=? WHERE deal_id=? AND document_id=? AND user_id=?";

    private array $tableProps = [
        self::DA_QRY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
        self::DA_QRY_USER_ID_KEY => [self::TBL_PROP_ENTITY_KEY => self::MKT_USER_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DA_QRY_DEAL_ID_KEY=> [self::TBL_PROP_ENTITY_KEY => self::DEAL_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT],
        self::DA_QRY_FILE_ID_KEY=> [self::TBL_PROP_ENTITY_KEY => self::DEAL_FILE_ENTITY,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => self::TBL_PROP_NONE_DEFAULT]
    ];

    public function insertNewDocAccess (array $params):mixed
    {
        if (array_key_exists(self::DA_QRY_ID_KEY, $params))
            unset($params[self::DA_QRY_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertDocAccessSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateDocAccessUserByDealIdFileId (int $userId, int $dealId, int $fileId, int $newUserId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateDocAccessUserSql,
            self::EXECUTE_MTHD,
            [$newUserId, $dealId, $fileId, $userId]
        );
    }

    public function returnBaseInsertArray():array
    {
        $base = [];
        each(function ($props, $key) use(&$base) {
            $base[$key] = null;
        }, $this->tableProps);
        return $base;
    }

    public function returnTablePropsArray ():array { return $this->tableProps; }
}
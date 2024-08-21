<?php

namespace App\Repository;

use App\Repository\DealFile\DocAccessInterface;
use App\Repository\DueDiligence\DueDiligenceInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use function Lambdish\Phunctional\each;

class DocAccess extends EntityRepository
    implements DocAccessInterface, DbalStatementInterface, DueDiligenceInterface
{
    use FetchingTrait, FetchMapperTrait;

    private string $insertDocAccessSql = "INSERT INTO DocAccess VALUE (null, ?, ?, ?)";

    private string $updateDocAccessUserSql = "UPDATE DocAccess SET user_id=? WHERE deal_id=? AND document_id=? AND user_id=?";

    private string $userDocAccessSql = "SELECT user_id FROM DocAccess WHERE deal_id = ? AND document_id = ?";

    private string $deleteFromDocAccessSql = "DELETE FROM DocAccess WHERE user_id=? AND deal_id = ? AND document_id = ?";

    private string $deleteAllAccessByFileIdSql = "DELETE FROM DocAccess WHERE document_id = ?";

    private string $multipleInsertDocAccessSql = "INSERT INTO DocAccess (`user_id`, `deal_id`, `document_id`) VALUES";

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

    public function fetchAllUsersWithDocAccess (int $dealId, $fileId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->userDocAccessSql,
            self::FETCH_NUMERIC_MTHD,
            [$dealId, $fileId]
        );
    }

    public function deleteFromDocAccess (int $userId, int $dealId, int $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteFromDocAccessSql,
            self::EXECUTE_MTHD,
            [$userId, $dealId, $fileId]
        );
    }

    public function removeAllFileAccessByFileId(int $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteAllAccessByFileIdSql,
            self::EXECUTE_MTHD,
            [$fileId]
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


    public function docAccessDueDilApiMapper ():array
    {
        return [
            self::DA_QRY_USER_ID_KEY => self::API_LOGGER_USER_ID_KEY,
            self::DA_QRY_DEAL_ID_KEY => self::API_DEAL_ID_KEY,
            self::DA_QRY_FILE_ID_KEY => self::API_DD_FILE_ID_KEY
        ];
    }

    public function createInsertParams($userId, $dealId, $documentId):array {
        return [
            self::DA_QRY_USER_ID_KEY => $userId,
            self::DA_QRY_DEAL_ID_KEY => $dealId,
            self::DA_QRY_FILE_ID_KEY => $documentId
        ];
    }

    public function addUsersDocAccess(array $usersIds, int $dealId, array $documentsIds)
    {
        $base = $this->multipleInsertDocAccessSql;
        $userInsertCount = 0;
        $docsInsertCount = 0;
        foreach ($usersIds as $userId) {
            $userInsertCount++;
            foreach ($documentsIds as $documentId) {
                $base = $base . PHP_EOL .
                    '(' . $userId . ',' . $dealId . ',' . $documentId . ')' .
                    ($userInsertCount == count($usersIds) &&
                        $docsInsertCount + 1 == count($documentsIds) *
                        count($usersIds) ? ';' : ','
                    );
                $docsInsertCount++;
            }
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }
}
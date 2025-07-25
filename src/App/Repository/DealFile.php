<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 11:10 AM
 */

namespace App\Repository;

use App\Repository\DealFile\DealFileInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;

class DealFile extends EntityRepository
    implements SqlManagerTraitInterface, DealFileInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    private static string $callFilesDataByLoanIds = 'call FilesDataByLoanIds(:loanIds)';

    static array $table = [
        self::DF_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_DEAL_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_USER_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_LOAN_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::DF_MIME_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_TYPE_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_FILE_NAME => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_FILE_SIZE => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_ASSET_ID => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_SCAN_LOC => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_VIRUS_IND => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::DF_ACC_MODE => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_PUB_PATH => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_DATE => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
    ];

    private string $updateAssetIdByIdSql = "UPDATE DealFile SET asset_id=? WHERE id=?";

    private string $updateFilePathByIdSql = "UPDATE DealFile SET public_path=? WHERE id=?";

    private string $updateFileNameByIdSql = "UPDATE DealFile SET file_name=? WHERE id=?";

    private string $fileIdFromPath = "SELECT id FROM DealFile WHERE public_path=?";

    private string $attachFileToLoanSql = "UPDATE DealFile SET loan_id=? WHERE id=?";

    private string $detachFileFromLoanSql = "UPDATE DealFile SET loan_id=NULL WHERE id=?";

    private string $detachDeleteDueDilFileRecordsSql = "DELETE FROM deal_file_due_diligence WHERE deal_file_id=?";

    private string $updateContractSignatureIdSql = "UPDATE DealFile SET contract_signature_id=? WHERE id=?";

    private string $fetchDealFileByIdSql = "SELECT * FROM DealFile WHERE id=?";

    private string $fetchFilesByDealIdSql = "SELECT * FROM DealFile WHERE deal_id =?";

    private string $fetchDocumentByAssetIdSql = "SELECT * FROM DealFile WHERE asset_id=?";

    private string $fetchAllDealFiles = "SELECT * FROM DealFile";

    private string $deleteFileByIdSql = "DELETE FROM DealFile WHERE id=?";

    private string $deleteDealFileByIdsSql = "DELETE FROM DealFile WHERE id IN (?)";

    private string $fetchDealFileIdsByDealIdSql = "SELECT id FROM DealFile Where deal_id=?";

    private string $unattachedFilesByDealIdSql = "SELECT * FROM `DealFile` WHERE `deal_id` =? AND loan_id IS NULL";

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchDealFileIdsByDealId(int $dealId)
    {
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchDealFileIdsByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );

        return $this->completeIdFetchQuery($results);
    }

    public function fetchUnattachedDealFiles(int $dealId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->unattachedFilesByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }

    public function fetchAllDealFiles(int $userId):mixed
    {
        if (!in_array($userId, self::MASTER_IDS))
            return ["message" => "User is not allowed to access this data"];
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAllDealFiles,
            self::FETCH_ALL_ASSO_MTHD,
        );
    }

    public function fetchDdSalesLoansFilesData (array $loanIds)
    {
        return $this->executeProcedure([implode(', ', $loanIds)], self::$callFilesDataByLoanIds);
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteDealFileByIds(array $ids):mixed
    {
        return $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->deleteDealFileByIdsSql,
            self::EXECUTE_MTHD,
            $ids
        );
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('DealFile');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function fetchFileIdFromPath(string $path):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fileIdFromPath,
            self::FETCH_NUMERIC_MTHD,
            [$path]
        );
    }

    /**
     * @param int $fileId
     * @param string $filePath
     * @return mixed
     */
    public function updateFilePathById (int $fileId, string $filePath):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateFilePathByIdSql,
            self::EXECUTE_MTHD,
            [$filePath, $fileId]
        );
    }

    /**
     * @param int $fileId
     * @param string $fileName
     * @return mixed
     */
    public function updateFileNameById(int $fileId, string $fileName):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateFileNameByIdSql,
            self::EXECUTE_MTHD,
            [$fileName, $fileId]
        );
    }

    /**
     * @param int $fileId
     * @param string $assetId
     * @return mixed
     */
    public function updateAssetIdById (int $fileId, string $assetId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateAssetIdByIdSql,
            self::EXECUTE_MTHD,
            [$assetId, $fileId]
        );
    }

    public function attachFileToLoan(int $loanId, int $fileId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->attachFileToLoanSql,
            self::EXECUTE_MTHD,
            [$loanId, $fileId]
        );
    }

    public function detachFileFromLoan($fileId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->detachFileFromLoanSql,
            self::EXECUTE_MTHD,
            [$fileId]
        );
    }

    public function detachDueDilFileRecordsByFileId(int $fileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->detachDeleteDueDilFileRecordsSql,
            self::EXECUTE_MTHD,
            [$fileId]
        );
    }

    public function updateContractSignature(int $contractSignId, int $dealFileId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateContractSignatureIdSql,
            self::EXECUTE_MTHD,
            [$contractSignId, $dealFileId]
        ); 
    }

    public function fetchDealFileByProps(
        int $dealId, 
        int $docTypeId, 
        int $userId, 
        int $communityUserId,
        ?int $bidId
    ) {
        $query = 
            "SELECT * FROM DealFile WHERE deal_id=? AND doc_type_id=? " .
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

    public function updateDealFileById(int $dealFileId, array $columnsValues)
    {
        $query = "UPDATE DealFile SET ";
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
        $values[] = $dealFileId;

        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $query,
            self::EXECUTE_MTHD,
            $values
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

    /**
     * @param int $dealId
     * @return mixed
     */
    public function fetchFilesDataByDealId(int $dealId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchFilesByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }

    /**
     * @param int $dealFileId
     * @return \Exception|mixed
     */
    public function fetchDealFileById(int $dealFileId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchDealFileByIdSql,
            self::FETCH_ASSO_MTHD,
            [$dealFileId]
        );
    }

    public function deleteFileById(int $dealFileId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteFileByIdSql,
            self::EXECUTE_MTHD,
            [$dealFileId]
        );
    }

}
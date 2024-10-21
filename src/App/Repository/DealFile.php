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
        self::DF_SIG_ID => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_SIG_PATH => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_COMMUNITY_USER_ID => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::DF_CONTRACT_SIGNATURE_ID => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::DF_DATE => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
    ];

    private string $updateAssetIdByIdSql = "UPDATE DealFile SET asset_id=? WHERE id=?";

    private string $updateFilePathByIdSql = "UPDATE DealFile SET public_path=? WHERE id=?";

    private string $fileIdFromPath = "SELECT id FROM DealFile WHERE public_path=?";

    private string $attachFileToLoanSql = "UPDATE DealFile SET loan_id=? WHERE id=?";

    private string $detachFileFromLoanSql = "UPDATE DealFile SET loan_id=NULL WHERE id=?";

    private string $detachDeleteDueDilFileRecordsSql = "DELETE FROM deal_file_due_diligence WHERE deal_file_id=?";

    private string $updateContractSignatureIdSql = "UPDATE DealFile SET contract_signature_id=? WHERE id=?";

    private static string $callFetchUserDealFilesContracts = "call FetchUserDealFilesContracts(:userId, :issuerId, :assetTypeId)";

    private static string $callFetchDealFilesContractsByUser = "call FetchDealFilesContractsByUser(:userId, :issuerId, :communityUserId, :communityIssuerId, :assetTypeId)";

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
        $sql = "SELECT id FROM DealFile Where deal_id = ?";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $dealId);
        return $this->completeIdFetchQuery($stmt);
    }

    public function fetchDdSalesLoansFilesData (array $loanIds)
    {
        return $this->executeProcedure([implode(', ', $loanIds)], self::$callFilesDataByLoanIds);
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteDealFileByIds(array $ids)
    {
        $sql = "DELETE FROM DealFile WHERE id IN (?)";
        $stmt = $this->returnInArraySqlStmt($this->em, $ids, $sql);
        $result = $stmt->execute();
        return $result;
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

    public function fetchFileIdFromPath(string $path):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fileIdFromPath,
            self::FETCH_NUMERIC_MTHD,
            [$path]
        );
    }

    public function updateFilePathById (int $fileId, string $filePath):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateFilePathByIdSql,
            self::EXECUTE_MTHD,
            [$filePath, $fileId]
        );
    }

    public function updateAssetIdById (int $fileId, string $assetId)
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

    public function fetchUserDealFilesContracts(int $userId, int $issuerId, int $assetTypeId)
    {
        return $this->executeProcedure([$userId, $issuerId, $assetTypeId], self::$callFetchUserDealFilesContracts);
    }

    public function fetchDealFilesContractsByUser(int $userId, int $issuerId, int $communityUserId, int $communityIssuerId, int $assetTypeId)
    {
        return $this->executeProcedure([$userId, $issuerId, $communityUserId, $communityIssuerId, $assetTypeId], self::$callFetchDealFilesContractsByUser);
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

}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 5:31 PM
 */

namespace App\Repository;

use App\Service\QueryManagerTrait;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Loan extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    private $subTypes = [
        'Auto' => '\AssetType\Auto',
        'Commercial' => '\AssetType\Commercial',
        'Cre' => '\AssetType\Cre',
        'CreditCard' => '\AssetType\CreditCard',
        'HomeEquity' => '\AssetType\HomeEquity',
        'Residential' => '\AssetType\Residential'
    ];

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'pool_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'state_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'msa_code_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'amortization_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'description_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'loan_id' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'original_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'current_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'monthly_payment' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'issuance_balance' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'initial_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'seasoning' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'current_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'origination_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'current_duefor_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'first_payment_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_status' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'final_duefor_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        'original_term' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NOT NULL'],
        'remaining_term' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        'amortization_term' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NOT NULL'],
        'io_term' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        'balloon_period' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        'original_ltv' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'original_cltv' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'appraised_value' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'credit_score' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NOT NULL'],
        'front_dti' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'back_dti' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'number_of_borrowers' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'first_time_buyer' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'lien_position' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'note_type' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'loan_type' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'documentation' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'purpose' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'occupancy' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'dwelling' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'address' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'city' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'zip' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'asset_attributes' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'payment_string' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'servicingfee' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'lpmi_fee' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'mi_coverage' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'foreclosure_date' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'bankruptcy_date' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'reo_date' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'zero_balance_date' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'loan_has_been_modified' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'end_mod_period' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        'channel' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'last_payment_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        'times_30' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'times_60' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'times_90' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'year_built' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'new_vs_used' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL']
    ];


    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchLoansByDealId(int $dealId)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT * FROM Pool WHERE deal_id IN (?)";
        $results = $this->fetchByIntArray($this->em, array($dealId), $sql);
        if(count($results) > 0){
            $results = $this->fetchLoansByPoolIds(array($results[0]['id']));
        }
        return $results;
    }

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchLoansByPoolIds(array $ids)
    {
        $sql = "SELECT loans.*, ArmAttribute.gross_margin, ArmAttribute.minimum_rate, ArmAttribute.maximum_rate, ArmAttribute.rate_index, ".
            "ArmAttribute.fst_rate_adj_period, ArmAttribute.fst_rate_adj_date, ArmAttribute.fst_pmnt_adj_period, ArmAttribute.fst_pmnt_adj_date, ArmAttribute.rate_adj_frequency, ".
            " ArmAttribute.periodic_cap, ArmAttribute.initial_cap, ArmAttribute.pmnt_adj_frequency, ArmAttribute.pmnt_increase_cap ".
            "FROM loans INNER JOIN ArmAttribute ON ArmAttribute.loan_id = loans.id WHERE loans.pool_id IN (?) ORDER BY pool_id ASC ";
        $armLoans = $this->fetchByIntArray($this->em, $ids, $sql);
        $noArms = [];
        if(count($armLoans) > 0){
            $loansId = [];
            foreach ($armLoans as $loan){
                array_push($loansId, $loan['id']);
            }
            $sql = "SELECT * FROM loans WHERE pool_id IN (?) AND id NOT IN (?) ORDER BY id ASC ";
            $stmt = $this->em->getConnection()->executeQuery($sql,
                array($ids, $loansId),
                array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY,
                    \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
            );
            $noArms = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        }
        $results = array_merge($noArms, $armLoans);
        return $results;
    }

    /**
     * @param array $poolIds
     * @return array|bool
     */
    public function fetchLoanIdsByPoolIds(array $poolIds)
    {
        $sql = "SELECT id FROM loans WHERE pool_id IN (?)";
        $stmt = $this->returnInArraySqlStmt($this->em, $poolIds, $sql);
        return $this->completeIdFetchQuery($stmt);
    }

    /**
     * @param array $loanIds
     * @return array
     */
    public function fetchLoanNumbersByLoanids(array $loanIds)
    {
        $sql = "SELECT id, loan_id FROM loans WHERE id IN (?) ORDER BY id ASC";
        $stmt = $this->returnInArraySqlStmt($this->em, $loanIds, $sql);
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $data = [];
        foreach ($result as $dbData){
            $data[$dbData['loan_id']] = (int)$dbData['id'];
        }
        return $data;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteLoansByIds(array $ids)
    {
        $sql = 'DELETE FROM loans WHERE id IN (?)';
        $stmt = $this->returnInArraySqlStmt($this->em, $ids, $sql);
        $result = $stmt->execute();
        return $result;
    }


    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('loans');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

}
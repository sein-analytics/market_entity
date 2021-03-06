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
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
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
        'initial_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
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
        'original_cltv' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'appraised_value' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        'credit_score' => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        'front_dti' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'back_dti' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
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
        'new_vs_used' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        'reserves' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'dealer_reserve' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'prepay_penalty_term' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        'prepay_penalty' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'prepay_step_down' => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL']
    ];

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

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
            $poolIds = $this->array_value_recursive('id', $results);
            try{
                $results = $this->fetchLoansByPoolIds($poolIds);
            } catch (DBALException $e){
                return ['message' => $e->getMessage()];
            }
        }
        return $results;
    }

    /**
     * @param array $ids
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function fetchLoansByPoolIds(array $ids)
    {
        $sql = "SELECT loans.*, ArmAttribute.gross_margin, ArmAttribute.minimum_rate, ArmAttribute.maximum_rate, ArmAttribute.rate_index, ".
            "ArmAttribute.fst_rate_adj_period, ArmAttribute.fst_rate_adj_date, ArmAttribute.fst_pmnt_adj_period, ArmAttribute.fst_pmnt_adj_date, ArmAttribute.rate_adj_frequency, ".
            " ArmAttribute.periodic_cap, ArmAttribute.initial_cap, ArmAttribute.pmnt_adj_frequency, ArmAttribute.pmnt_increase_cap, lnState.abbreviation AS state, ".
            " SaleAttribute.availability, CommAttribute.dscr, CommAttribute.noi, CommAttribute.net_worth_to_loan, CommAttribute.profit_ratio, CommAttribute.loan_to_cost_ratio, ".
            "CommAttribute.debt_yield_ratio, CommAttribute.vacancy_rate, CommAttribute.lockout_period, CommAttribute.defeasance_date, CommAttribute.cap_rate ".
            "FROM loans ".
            "LEFT JOIN ArmAttribute ON ArmAttribute.loan_id = loans.id " .
            "LEFT JOIN SaleAttribute ON SaleAttribute.loan_id = loans.id " .
            "LEFT JOIN CommAttribute ON CommAttribute.loan_id = loans.id " .
            "LEFT JOIN  State lnState ON  lnState.id = loans.state_id " .
            "WHERE loans.pool_id IN (?) ORDER BY pool_id ASC ";
        $armLoans = $this->fetchByIntArray($this->em, $ids, $sql);
        $loansId = [];
        if(count($armLoans) > 0){
            foreach ($armLoans as $loan){
                array_push($loansId, $loan['id']);
            }
        }
        $sql = "SELECT loans.*, lnState.abbreviation AS state FROM loans LEFT JOIN State lnState ON lnState.id=loans.state_id WHERE pool_id IN (?) AND loans.id NOT IN (?) ORDER BY loans.id ASC";
        $stmt = $this->em->getConnection()->executeQuery($sql,
            array($ids, $loansId),
            array(Connection::PARAM_INT_ARRAY,
                Connection::PARAM_INT_ARRAY)
        );
        $noArms = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $results = array_merge($noArms, $armLoans);
        $stmt->closeCursor();
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
        $stmt->closeCursor();
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

    public function fetchLoanIdsIdsByPoolIds(array $poolIds)
    {
        $sql = 'SELECT loans.id, loan_id, ddStat.status_id, dd_id, user_id, dd_role_id, first_name, last_name, status FROM loans ' .
            'LEFT JOIN DueDilLoanStatus ddStat on ddStat.ln_id = loans.id ' .
            'LEFT JOIN DueDiligence dd on dd.id=dd_id ' .
            'LEFT JOIN MarketUser users ON users.id=user_id ' .
            'LEFT JOIN DueDilReviewStatus revStat on revStat.id=ddStat.status_id ' .
            'WHERE pool_id IN (?) ORDER BY id ASC';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($poolIds), array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
        );
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $result;
    }

    public function fetchLoanIdFromId(int $id)
    {
        $sql = "SELECT loan_id FROM loans WHERE id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        if (is_array($result) && array_key_exists('loan_id', $result))
            return $result['loan_id'];
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
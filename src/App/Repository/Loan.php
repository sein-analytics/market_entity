<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 5:31 PM
 */

namespace App\Repository;

use App\Repository\Loan\LoanInterface;
use App\Service\QueryManagerTrait;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class Loan extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, LoanInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    const LOAN_NUMS_BY_IDS_SQL = "SELECT id, loan_id FROM loans WHERE id IN (?) ORDER BY id ASC";

    private $subTypes = [
        'Auto' => '\AssetType\Auto',
        'Commercial' => '\AssetType\Commercial',
        'Cre' => '\AssetType\Cre',
        'CreditCard' => '\AssetType\CreditCard',
        'HomeEquity' => '\AssetType\HomeEquity',
        'Residential' => '\AssetType\Residential'
    ];

    static $table = [
        self::ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::POOL_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::STATE_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::MSA_CODE_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::AMORT_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::DESC_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::LOAN_ID_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::ORIG_BAL_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        self::CURR_BAL_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        self::MON_PMT_KEY=> [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::ISSUE_BAL_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::INIT_RATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::SEASNING_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::CURR_RATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        self::ORIG_DATE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::DUE_FOR_DATE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::FST_PAY_DATE => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::LOAN_STAT_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::FIN_DUE_DATE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::ORIG_TERM_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NOT NULL'],
        self::REM_TERM_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        self::AMORT_TERM_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NOT NULL'],
        self::IO_TERM_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        self::BALON_TERM_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        self::ORIG_LTV_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        self::ORIG_CLTV_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::APPR_VAL_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
        self::CREDIT_SC_KEY => [self::DATA_TYPE => ['decimal', 'integer'], self::DATA_DEFAULT => 'NULL'],
        self::FRONT_DTI_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::BACK_DTI_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::NUM_BORR_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::FST_TIMEB_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::LIEN_POS_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::NOTE_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::LOAN_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::DOC_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::PUR_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::OCCU_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::DWELL_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        //self::ADDR_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::CITY_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::ZIP_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::ASST_ATTR_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::PMT_STR_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::SVC_FEE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::LPMI_FEE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::MI_COV_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::FORC_DATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::BKRY_DATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::REO_DATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::ZERO_BAL_DATE_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::LOAN_MOD_IND_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::END_MOD_PER_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        self::CHANNEL_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::LAST_PMT_DATE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NULL'],
        self::TIMES_30_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::TIMES_60_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::TIMES_90_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::YR_BUILT_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::NEW_USED_IND_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::RESERVES_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::DEALR_RSVS_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::PP_PNLTY_TERM_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::PP_PNLTY_KEY => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        self::PP_PNLTY_STEP_KEY => [self::DATA_TYPE => 'json', self::DATA_DEFAULT => 'NULL'],
        'as_of_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
    ];

    private string $fetchLoanIdsByPoolIdsSql = "SELECT id FROM loans WHERE pool_id IN (?)";

    private string $deleteLoansByIdsSql = "DELETE FROM loans WHERE id IN (?)";

    private string $fetchLoanIdFromIdSql = "SELECT loan_id FROM loans WHERE id = ?";

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
        $sql = "SELECT * FROM Pool WHERE deal_id IN (?)";
        $results = $this->fetchByIntArray($this->em, array($dealId), $sql);
        if(count($results) > 0){
            $poolIds = $this->array_value_recursive('id', $results);
            try{
                $results = $this->fetchLoansByPoolIds($poolIds);
            } catch (\Exception $e){
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
            " CommAttribute.debt_yield_ratio, CommAttribute.vacancy_rate, CommAttribute.lockout_period, CommAttribute.defeasance_date, CommAttribute.cap_rate, ".
            " DelinquencyAttribute.servicer, DelinquencyAttribute.sub_servicer, DelinquencyAttribute.servicer_notes, DelinquencyAttribute.sub_servicer_notes, DelinquencyAttribute.servicer_status, DelinquencyAttribute.sub_servicer_status, ".
            " DelinquencyAttribute.master_servicer, DelinquencyAttribute.master_servicer_status, DelinquencyAttribute.asset_manager, DelinquencyAttribute.asset_manager_status, DelinquencyAttribute.asset_manager_sub_status, DelinquencyAttribute.days_delinquent, ".
            " DelinquencyAttribute.delinquent_principal, DelinquencyAttribute.delinquent_interest, DelinquencyAttribute.total_delinquent_balance, DelinquencyAttribute.general_notes, DelinquencyAttribute.sub_status, DelinquencyAttribute.sub_status_notes, ".
            " EscrowAttribute.total_debt_balance, EscrowAttribute.accrued_late_fees, EscrowAttribute.escrow_balance, EscrowAttribute.restricted_escrow, EscrowAttribute.escrow_advance_balance, EscrowAttribute.corp_advance_balance, ".
            " EscrowAttribute.third_party_balance, EscrowAttribute.accrued_balance, EscrowAttribute.tax_and_insurance_payment, ".
            " ForeclosureAttribute.foreclosure_start_date, ForeclosureAttribute.foreclosure_bid_amount, ForeclosureAttribute.actual_sale_date, ForeclosureAttribute.judgement_date, ForeclosureAttribute.referred_to_atty_date, ForeclosureAttribute.service_complete_date, ".
            " ForeclosureAttribute.foreclosure_status, ForeclosureAttribute.schedule_sale_date, ForeclosureAttribute.completed_date, ForeclosureAttribute.removal_date, ForeclosureAttribute.suspended_date, ForeclosureAttribute.foreclosure_type, ".
            " ForeclosureAttribute.foreclosure_type, ForeclosureAttribute.next_step_date, ForeclosureAttribute.referral_date, ".
            " LossMitigationAttribute.setup_date, LossMitigationAttribute.loss_mitigation_status, LossMitigationAttribute.removal_date, ".
            " ModificationAttribute.modification_date, ModificationAttribute.capitalized_amount, ModificationAttribute.modification_status, ModificationAttribute.post_principal_balance, ".
            " PayHistoryAttribute.history1, PayHistoryAttribute.history2, PayHistoryAttribute.history3, PayHistoryAttribute.history4, PayHistoryAttribute.history5, PayHistoryAttribute.history6, ".
            " PayHistoryAttribute.history7, PayHistoryAttribute.history8, PayHistoryAttribute.history9, PayHistoryAttribute.history10, PayHistoryAttribute.history11, PayHistoryAttribute.history12, ".
            " PropertyAttribute.address, PropertyAttribute.report_links, PropertyAttribute.price_comps, PropertyAttribute.property_pictures, PropertyAttribute.property_links, PropertyAttribute.seller_as_is_value ".
            "FROM loans ".
            "LEFT JOIN ArmAttribute ON ArmAttribute.loan_id = loans.id " .
            "LEFT JOIN SaleAttribute ON SaleAttribute.loan_id = loans.id " .
            "LEFT JOIN CommAttribute ON CommAttribute.loan_id = loans.id " .
            "LEFT JOIN State lnState ON  lnState.id = loans.state_id " .
            "LEFT JOIN DelinquentAttribute ON DelinquentAttribute.loan_id = loans.id " .
            "LEFT JOIN EscrowAttribute ON EscrowAttribute.loan_id = loans.id " .
            "LEFT JOIN ForeclosureAttribute ON ForeclosureAttribute.loan_id = loans.id " .
            "LEFT JOIN LossMitigationAttribute ON LossMitigationAttribute.loan_id = loans.id " .
            "LEFT JOIN ModificationAttribute ON ModificationAttribute.loan_id = loans.id " .
            "LEFT JOIN PayHistoryAttribute ON PayHistoryAttribute.loan_id = loans.id " .
            "LEFT JOIN PropertyAttribute ON PropertyAttribute.loan_id = loans.id " .
            "WHERE loans.pool_id IN (?) ORDER BY pool_id ASC ";
        $armLoans = $this->fetchByIntArray($this->em, $ids, $sql);
        $loansId = [];
        if(count($armLoans) > 0){
            foreach ($armLoans as $loan){
                array_push($loansId, $loan['id']);
            }
        }
        $sql = "SELECT loans.*, lnState.abbreviation AS state FROM loans LEFT JOIN State lnState ON lnState.id=loans.state_id WHERE pool_id IN (?) AND loans.id NOT IN (?) ORDER BY loans.id ASC";
        
        $noArms = $this->buildAndExecuteMultiIntStmt(
            $this->em,
            $sql,
            self::FETCH_ALL_ASSO_MTHD,
            $ids, $loansId
        );
        
        $results = array_merge($noArms, $armLoans);
        
        return $results;
    }

    /**
     * @param array $poolIds
     * @return array|bool
     */
    public function fetchLoanIdsByPoolIds(array $poolIds)
    {
        $results = $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->fetchLoanIdsByPoolIdsSql,
            self::FETCH_ALL_ASSO_MTHD,
            $poolIds
        );

        if (count($results) > 0) {
            $results = $this->flattenResultArrayByKey($results, self::QUERY_JUST_ID);
        } else {
            $results = false;
        }

        return $results;
    }

    /**
     * @param array $loanIds
     * @return array|string
     */
    public function fetchLoanNumbersByLoanIds(array $loanIds)
    {
        try {

            $results = $this->buildAndExecuteIntArrayStmt(
                $this->em,
                self::LOAN_NUMS_BY_IDS_SQL,
                self::FETCH_ALL_ASSO_MTHD,
                $loanIds
            );
        } catch (\Doctrine\DBAL\Driver\Exception $err){
            return $err->getMessage();
        }
        return $this->flattenByKeyValue($results, self::LOAN_ID_KEY, self::ID_KEY,
            $this->dbValueSubStringFromCharClosure(self::APPEND_UNDER_SCORE),
            $this->dbValueToIntClosure()
        );
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteLoansByIds(array $ids)
    {
        return $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $this->deleteLoansByIdsSql,
            self::EXECUTE_MTHD,
            $ids
        );
    }

    public function fetchLoanIdsIdsByPoolIds(array $poolIds)
    {
        $sql = 'SELECT loans.id, loan_id, ddStat.status_id, dd_id, user_id, dd_role_id, first_name, last_name, status FROM loans ' .
            'LEFT JOIN DueDilLoanStatus ddStat on ddStat.ln_id = loans.id ' .
            'LEFT JOIN DueDiligence dd on dd.id=dd_id ' .
            'LEFT JOIN MarketUser users ON users.id=user_id ' .
            'LEFT JOIN DueDilReviewStatus revStat on revStat.id=ddStat.status_id ' .
            'WHERE pool_id IN (?) ORDER BY id ASC';

        return $this->buildAndExecuteIntArrayStmt(
            $this->em,
            $sql,
            self::FETCH_ALL_ASSO_MTHD,
            $poolIds
        );
    }

    public function fetchLoanIdFromId(int $id)
    {
        $result = $this->buildAndExecuteFromSql(
            $this->em,
            $this->fetchLoanIdFromIdSql,
            self::FETCH_ASSO_MTHD,
            [$id]
        );

        if (is_array($result) && array_key_exists('loan_id', $result)) {
            return $result['loan_id'];
        }
        
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
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/25/17
 * Time: 9:44 AM
 */

namespace App\Entity\Loan;


use Doctrine\ORM\EntityRepository;

class LoanPropertyLabel extends EntityRepository
{
    const LOAN_DATA = 'loanData';

    const CREDIT_DATA = 'creditData';

    const MTGE_DATA = 'mortgageData';

    const ARM_DATA = 'armData';

    const FEES_DATA = 'feesData';

    const CATEGORY = 'category';

    const SIGNIFICANCE = 'significance';

    const DB_NAME = 'dbName';

    const REQUIRED = 'required';

    const OPTIONAL = 'optional';

    const CONDITIONAL = 'conditional';

    const LABEL = 'label';

    const ENTITY_TYPE = 'type';

    const ENTITY_FIELD = 'field';

    private $propertyLabels = [
        'loan_id' => [self::LABEL => 'Loan Id', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'original_balance' => [self::LABEL => 'Original Balance', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'current_balance' => [self::LABEL => 'Current Balance', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'monthly_payment' => [self::LABEL => 'Monthly Payment', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'current_rate' => [self::LABEL => 'Current Rate', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'origination_date' => [self::LABEL => 'Closing Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'first_payment_date' => [self::LABEL => 'First Payment Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'final_duefor_date' => [self::LABEL => 'Maturity Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'original_term' => [self::LABEL => 'Original Term', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'remaining_term' => [self::LABEL => 'Remaining Term', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'amortization_term' => [self::LABEL => 'Amortization Term', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'current_duefor_date' => [self::LABEL => 'Paid-Through Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'io_term' => [self::LABEL => 'Paid-Through Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'balloon_period' => [self::LABEL => 'Balloon Date', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'original_ltv' => [self::LABEL => 'Original LTV', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'original_cltv' => [self::LABEL => 'Original CLTV', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'credit_score' => [self::LABEL => 'Credit Score', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'front_dti' => [self::LABEL => 'Front DTI Ratio', self::CATEGORY => self::CREDIT_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'back_dti' => [self::LABEL => 'Back DTI Ratio', self::CATEGORY => self::CREDIT_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'number_of_borrowers' => [self::LABEL => 'Number of Borrowers', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'first_time_buyer_indicator' => [self::LABEL => 'First -time Buyer Indicator', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'loan_status' => [self::LABEL => 'Status', self::CATEGORY => self::CREDIT_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'payment_string' => [self::LABEL => 'Payment History', self::CATEGORY => self::CREDIT_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'lien_position' => [self::LABEL => 'Lien Position', self::CATEGORY => self::CREDIT_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'documentation' => [self::LABEL => 'Documentation', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'purpose' => [self::LABEL => 'Purpose', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'occupancy' => [self::LABEL => 'Occupancy', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'dwelling' => [self::LABEL => 'Property Type', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'loan_type' => [self::LABEL => 'Loan Type', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'address' => [self::LABEL => 'Address', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'state_id' => [self::LABEL => 'State', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'city' => [self::LABEL => 'City', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'zip' => [self::LABEL => 'Zip Code', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'msa_code_id' => [self::LABEL => 'MSA CODE', self::CATEGORY => self::MTGE_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'rate_index' => [self::LABEL => 'Rate Index', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'gross_margin' => [self::LABEL => 'Gross Margin', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'minimum_rate' => [self::LABEL => 'Minimum Rate', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'maximum_rate' => [self::LABEL => 'Maximum Rate', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'initial_cap' => [self::LABEL => 'Initial Cap', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'periodic_cap' => [self::LABEL => 'Periodic Cap', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'rate_adj_frequency' => [self::LABEL => 'Rate Adjustment Frequency', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'fst_rate_adj_date' => [self::LABEL => 'First Rate Adjustment Date', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'fst_rate_adj_period' => [self::LABEL => 'Rate Index', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'fst_pmt_adj_date' => [self::LABEL => 'Fist Payment Adjustment Date', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::CONDITIONAL],
        'fst_pmt_adj_period' => [self::LABEL => 'Fist Payment Adjustment Period', self::CATEGORY => self::ARM_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'servicingfee' => [self::LABEL => 'Servicing Fee', self::CATEGORY => self::FEES_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'lpmi_fee' => [self::LABEL => 'LPMI Fee', self::CATEGORY => self::FEES_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'mi_coverage' => [self::LABEL => 'MI Coverage', self::CATEGORY => self::FEES_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'seasoning' => [self::LABEL => 'Servicing Fee', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL],
        'initial_rate' => [self::LABEL => 'Servicing Fee', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::REQUIRED],
        'appraised_value' => [self::LABEL => 'Appraised Value', self::CATEGORY => self::LOAN_DATA, self::SIGNIFICANCE => self::OPTIONAL]
    ];

    public function buildTapeUploadArray()
    {
        /** @var \Doctrine\ORM\Mapping\ClassMetadata $repo */
        $classMeta = $this->getEntityManager()->getClassMetadata('\App\Entity\Loan');
        $name = $classMeta->getName();
        foreach ($this->propertyLabels as $prop => $props){
            $metaData = $classMeta->fieldMappings[$prop];
        }
    }

    public function getPropertyLabels()
    {
        return $this->propertyLabels;
    }
}
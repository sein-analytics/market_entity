<?php

namespace App\Repository\Loan;

interface LoanInterface
{
    const ID_KEY = 'id';

    const POOL_ID_KEY = 'pool_id';

    const STATE_ID_KEY = 'state_id';

    const MSA_CODE_ID_KEY = 'msa_code_id';

    const AMORT_ID_KEY = 'amortization_id';

    const DESC_ID_KEY = 'description_id';

    const LOAN_ID_KEY = 'loan_id';

    const ORIG_BAL_KEY = 'original_balance';

    const CURR_BAL_KEY = 'current_balance';

    const MON_PMT_KEY = 'monthly_payment';

    const ISSUE_BAL_KEY = 'issuance_balance';

    const INIT_RATE_KEY = 'initial_rate';

    const SEASNING_KEY = 'seasoning';

    const CURR_RATE_KEY = 'current_rate';

    const ORIG_DATE_KEY = 'origination_date';

    const DUE_FOR_DATE_KEY = 'current_duefor_date';

    const FST_PAY_DATE = 'first_payment_date';

    const LOAN_STAT_KEY = 'loan_status';

    const FIN_DUE_DATE_KEY = 'final_duefor_date';

    const ORIG_TERM_KEY = 'original_term';

    const REM_TERM_KEY = 'remaining_term';

    const AMORT_TERM_KEY = 'amortization_term';

    const IO_TERM_KEY = 'io_term';

    const BALON_TERM_KEY = 'balloon_period';

    const ORIG_LTV_KEY = 'original_ltv';

    const ORIG_CLTV_KEY = 'original_cltv';

    const APPR_VAL_KEY = 'appraised_value';

    const CREDIT_SC_KEY = 'credit_score';

    const FRONT_DTI_KEY = 'front_dti';

    const BACK_DTI_KEY = 'back_dti';

    const NUM_BORR_KEY = 'number_of_borrowers';

    const FST_TIMEB_KEY = 'first_time_buyer';

    const LIEN_POS_KEY = 'lien_position';

    const NOTE_TYPE_KEY = 'note_type';

    const LOAN_TYPE_KEY = 'loan_type';

    const DOC_TYPE_KEY = 'documentation';

    const PUR_TYPE_KEY = 'purpose';

    const OCCU_TYPE_KEY = 'occupancy';

    const DWELL_TYPE_KEY = 'dwelling';

    const ADDR_KEY = 'address';

    const CITY_KEY = 'city';

    const ZIP_KEY = 'zip';

    const ASST_ATTR_KEY = 'asset_attributes';

    const PMT_STR_KEY = 'payment_string';

    const SVC_FEE_KEY = 'servicingfee';

    const LPMI_FEE_KEY = 'lpmi_fee';

    const MI_COV_KEY = 'mi_coverage';

    const FORC_DATE_KEY = 'foreclosure_date';

    const BKRY_DATE_KEY = 'bankruptcy_date';

    const REO_DATE_KEY = 'reo_date';

    const ZERO_BAL_DATE_KEY = 'zero_balance_date';

    const LOAN_MOD_IND_KEY = 'loan_has_been_modified';

    const END_MOD_PER_KEY = 'end_mod_period';

    const CHANNEL_KEY = 'channel';

    const LAST_PMT_DATE_KEY = 'last_payment_date';

    const TIMES_30_KEY = 'times_30';

    const TIMES_60_KEY = 'times_60';

    const TIMES_90_KEY = 'times_90';

    const YR_BUILT_KEY = 'year_built';

    const NEW_USED_IND_KEY = 'new_vs_used';

    const RESERVES_KEY = 'reserves';

    const DEALR_RSVS_KEY = 'dealer_reserve';

    const PP_PNLTY_TERM_KEY = 'prepay_penalty_term';

    const PP_PNLTY_KEY = 'prepay_penalty';

    const PP_PNLTY_STEP_KEY = 'prepay_step_down';

    const AS_OF_DATE_KEY = 'as_of_date';

    const PURCHASE_DATE_KEY = 'purchase_date';

    const APPEND_UNDER_SCORE = '_';

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

    const DB_DATA = 'dbData';

    const LABEL = 'label';

    const ENTITY_TYPE = 'type';

    const ENTITY_FIELD = 'fieldName';

    const ENTITY_NULL = 'nullable';

    const ENTITY_COLUMN = 'columnName';

    const STATE_AB_KEY = 'abbreviation';

    const STATE_NAME_KEY = 'name';

    const SLUG_KEY = 'slug';

    const MAPPED_ID_KEY = 'mapped-id';

    const HAY_KEY = 'haystack';

    const SEARCH_KEY = 'search';

    const BASE_STATE_ID = 51;

    const LOANS_TABLE_CATEGORY = 'loanData';

    const ARM_ATTR_CATEGORY = 'ArmAttribute';

    const AMORT_ATTR_CATEGORY = 'AmortAttribute';

    const BK_ATTR_CATEGORY = 'BankruptcyAttribute';

    const COMM_ATTR_CATEGORY = 'CommAttribute';

    const DQ_ATTR_CATEGORY = 'DelinquentAttribute';

    const DES_ATTR_CATEGORY = 'DescAttribute';

    const ESCROW_ATTR_CATEGORY = 'EscrowAttribute';

    const FORCS_ATTR_CATEGORY = 'ForeclosureAttribute';

    const IO_ATTR_CATEGORY = 'InterestOnlyAttribute';

    const LOSS_MIT_CATEGORY = 'LossMitigationAttribute';

    const MOD_CATEGORY = 'ModificationAttribute';

    const PAY_HIST_CATEGORY = 'PayHistoryAttribute';

    const PROPERTY_CATEGORY = 'PropertyAttribute';

    const SALE_CATEGORY = 'SaleAttribute';

    const ARM_ATTRIBUTE_CLASS = 'App\Entity\Loan\ArmAttribute';

    const AMORT_ATTRIBUTE_CLASS = 'App\Entity\Loan\AmortAttribute';

    const BK_ATTRIBUTE_CLASS = 'App\Entity\Loan\BankruptcyAttribute';

    const COMM_ATTRIBUTE_CLASS = 'App\Entity\Loan\CommAttribute';

    const DQ_ATTRIBUTE_CLASS = 'App\Entity\Loan\DelinquentAttribute';

    const DES_ATTRIBUTE_CLASS = 'App\Entity\Loan\DescAttribute';

    const ESCROW_ATTRIBUTE_CLASS = 'App\Entity\Loan\EscrowAttribute';

    const FORC_ATTRIBUTE_CLASS = 'App\Entity\Loan\ForeclosureAttribute';

    const INT_ONLY_ATTRIBUTE_CLASS = 'App\Entity\Loan\InterestOnlyAttribute';

    const LOSS_MIY_ATTRIBUTE_CLASS = 'App\Entity\Loan\LossMitigationAttribute';

    const MOD_ATTRIBUTE_CLASS = 'App\Entity\Loan\ModificationAttribute';

    const PAY_HIST_ATTRIBUTE_CLASS = 'App\Entity\Loan\PayHistoryAttribute';

    const PROPERTY_ATTRIBUTE_CLASS = 'App\Entity\Loan\PropertyAttribute';

    const SALE_ATTRIBUTE_CLASS = 'App\Entity\Loan\SaleAttribute';

    const LOAN_CATEGORY_MAPPER = [
        self::ARM_ATTRIBUTE_CLASS => self::ARM_ATTR_CATEGORY,
        self::AMORT_ATTRIBUTE_CLASS => self::AMORT_ATTR_CATEGORY,
        self::BK_ATTRIBUTE_CLASS => self::BK_ATTR_CATEGORY,
        self::COMM_ATTRIBUTE_CLASS => self::COMM_ATTR_CATEGORY,
        self::DQ_ATTRIBUTE_CLASS => self::DQ_ATTR_CATEGORY,
        self::DES_ATTRIBUTE_CLASS => self::DES_ATTR_CATEGORY,
        self::ESCROW_ATTRIBUTE_CLASS => self::ESCROW_ATTR_CATEGORY,
        self::FORC_ATTRIBUTE_CLASS => self::FORCS_ATTR_CATEGORY,
        self::INT_ONLY_ATTRIBUTE_CLASS => self::IO_ATTR_CATEGORY,
        self::LOSS_MIY_ATTRIBUTE_CLASS => self::LOSS_MIT_CATEGORY,
        self::MOD_ATTRIBUTE_CLASS => self::MOD_CATEGORY,
        self::PAY_HIST_ATTRIBUTE_CLASS => self::PAY_HIST_CATEGORY,
        self::PROPERTY_ATTRIBUTE_CLASS => self::PROPERTY_CATEGORY,
        self::SALE_ATTRIBUTE_CLASS => self::SALE_CATEGORY,
    ];

    const FIELD_MAPPINGS_TO_ROW = [
        self::ENTITY_COLUMN =>self::DB_NAME,
        self::ENTITY_TYPE =>self::ENTITY_TYPE
    ];
}
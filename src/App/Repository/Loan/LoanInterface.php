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

    const APPEND_UNDER_SCORE = '_';
}
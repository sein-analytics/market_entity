<?php
namespace App\Repository\Statistic;
interface StatisticInterface
{
    const STATS_TABLE_NAME = 'Statistic';

    const STATS_ID_KEY = 'id';

    const STATS_DEAL_ID_KEY = 'deal_id';

    const STATS_STATES_KEY = 'states';

    const SUMRY_STATES_KEY = 'summary_states';

    const STATS_LTV_KEY = 'ltv';

    const SUMRY_LTV_KEY = 'summary_ltv';

    const STATS_BAL_KEY = 'balance';

    const SUMRY_BAL_KEY = 'summary_balance';

    const STATS_RATE_KEY = 'rate';

    const SUMRY_RATE_KEY = 'summary_rate';

    const STATS_LOAN_TYPE_KEY = 'loan_type';

    const STATS_PROP_TYPE_KEY = 'property_type';

    const STATS_OCCU_KEY = 'occupancy';

    const STATS_MAT_KEY = 'maturity';

    const SUMRY_MAT_KEY = 'summary_maturity';

    const STATS_CREDIT_KEY = 'credit';

    const SUMRY_CREDIT_KEY = 'summary_credit';

    const STATS_FILTER_KEY = 'filter_data';

    const SELECT_ALL_BY_DEAL_SQL = "SELECT * FROM Statistic WHERE ". self::STATS_DEAL_ID_KEY . " IN (?)";

    const SELECT_ID_BY_DEAL_SQL = "SELECT ". self::STATS_ID_KEY . " FROM Statistic WHERE " .
    self::STATS_DEAL_ID_KEY . " = ?";

}
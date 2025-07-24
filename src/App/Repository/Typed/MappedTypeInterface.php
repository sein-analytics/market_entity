<?php

namespace App\Repository\Typed;

interface MappedTypeInterface
{
    const ARM_INDEX_TYPE_DB = 'ArmIndexType';

    const PURPOSE_TYPE_DB = 'PurposeType';

    const OCCUPANCY_TYPE_DB = 'OccupancyType';

    const STATUS_TYPE_DB = 'StatusType';

    const LOAN_TYPE_DB = 'LoanType';

    const PROPERTY_TYPE_DB = 'PropertyType';

    const DOCUMENTATION_TYPE_DB = 'DocumentationType';

    const STATE_DB = 'State';

    const LIEN_TYPE_DB = 'LienType';

    const NEW_USED_DB = 'NewUsed';

    const YEAR_BUILT_DB = 'YearBuilt';

    const ARM_INDEX_TYPE_PROP = 'armIndexType';

    const PURPOSE_TYPE_PROP = 'purposeType';

    const OCCUPANCY_TYPE_PROP = 'occupancyType';

    const STATUS_TYPE_PROP = 'statusType';

    const LOAN_TYPE_PROP = 'loanType';

    const PROPERTY_TYPE_PROP = 'dwelling';

    const DOCUMENTATION_TYPE_PROP = 'documentation';

    const STATE_PROP = 'state';

    const LIEN_TYPE_PROP = 'lien';

    const NEW_USED_PROP = 'newUsed';

    const YEAR_BUILT_PROP = 'yearBuilt';

    const PROP_TO_TABLE_MAP = [
        self::ARM_INDEX_TYPE_PROP => self::ARM_INDEX_TYPE_DB,
        self::PURPOSE_TYPE_PROP => self::PURPOSE_TYPE_DB,
        self::OCCUPANCY_TYPE_PROP => self::OCCUPANCY_TYPE_DB,
        self::STATUS_TYPE_PROP => self::STATUS_TYPE_DB,
        self::LOAN_TYPE_DB => self::LOAN_TYPE_DB,
        self::PROPERTY_TYPE_PROP => self::PROPERTY_TYPE_DB,
        self::DOCUMENTATION_TYPE_PROP => self::DOCUMENTATION_TYPE_DB,
        self::STATE_PROP => self::STATE_DB,
        self::LIEN_TYPE_PROP => self::LIEN_TYPE_DB,
        self::NEW_USED_PROP => self::NEW_USED_DB,
        self::YEAR_BUILT_PROP => self::YEAR_BUILT_DB,
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 12:27 PM
 */

namespace App\Service;


interface SqlManagerTraitInterface
{
    const DATA_TYPE = 'type';

    const DATA_DEFAULT = 'default';

    const PROP_CATEGORY_KEY = 'category';

    const LOANS_TABLE_CATEGORY = 'loanData';

    const ARM_ATTR_CATEGORY = 'ArmAttribute';

    const BK_ATTR_CATEGORY = 'BankruptcyAttribute';

    const COMM_ATTR_CATEGORY = 'CommAttribute';

    const DQ_ATTR_CATEGORY = 'DelinquentAttribute';

    const ESCROW_ATTR_CATEGORY = 'EscrowAttribute';

    const FORCS_ATTR_CATEGORY = 'ForeclosureAttribute';

    const IO_ATTR_CATEGORY = 'InterestOnlyAttribute';

    const LOSS_MIT_CATEGORY = 'LossMitigationAttribute';

    const MOD_CATEGORY = 'ModificationAttribute';

    const PAY_HIST_CATEGORY = 'PayHistoryAttribute';

    const PROPERTY_CATEGORY = 'PropertyAttribute';

    const SALE_CATEGORY = 'SaleAttribute';

    const INSERT__SQL_START = "INSERT INTO ";

    const TYPE_MAPPER = [
        'integer' => 'int',
        'string'  => ['varchar', 'json'],
        'double'  => 'decimal',
        'float'   => 'decimal',
        'boolean' => 'tinyint'
    ];

    /**
     * @return bool|mixed
     */
    function fetchNextAvailableId();

    /**
     * @param string|null $subType
     * @return bool|mixed
     */
    function fetchEntityPropertiesForSql(string $subType = null);

    function fetchTableColumnNumericalIndex(string $colName);

    function buildInsertSqlStatement(string $tableName);

    public function buildInsertElementStatement(array $data);
}
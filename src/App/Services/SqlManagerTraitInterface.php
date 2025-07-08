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
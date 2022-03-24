<?php

namespace App\Repository;

use App\Repository\Community\CommunityAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;

class CommunityInvite extends CommunityAbstract
{
    use FetchMapperTrait, FetchingTrait, QueryManagerTrait;

    static $table = [
        self::COMM_DB_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_INV_DB_COMM_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_INV_DB_STATUS_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_INV_DB_USER_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::COMM_INV_DB_EMAIL_KEY => [self::DATA_TYPE => 'string', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_INV_DB_INVITE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_INV_DB_UUID_KEY => [self::DATA_TYPE => 'string', self::DATA_DEFAULT => 'NOT NULL'],
    ];
    function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('CommunityInvite');
    }

    function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
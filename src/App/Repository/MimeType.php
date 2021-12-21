<?php

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityRepository;

class MimeType extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    const EXT_KEY = 'ext';

    const MIME_TYPE_KEY = 'mime_type';

    const EXT_ID_SQL = 'SELECT ext, id FROM MimeType';

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::EXT_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::MIME_TYPE_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
    ];

    public function fetchAllExtAndId()
    {
        $result = $this->buildAndExecuteFromSql(
            $this->em,
            self::EXT_ID_SQL,
            self::FETCH_ALL_ASSO_MTHD,
            []
        );
        if ($result instanceof \Exception)
            return $result->getMessage();
        return $this->flattenByKeyValue($result, self::EXT_KEY, 'id',
            $this->dbValueRawCloser(), $this->dbValueToIntClosure());
    }

    function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('MimeType');
    }

    function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

}
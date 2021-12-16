<?php

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class MimeType extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'ext' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        'mime_type' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
    ];

    public function fetchExtAndId()
    {
        try {
            $stmt = $this->em->getConnection()->prepare('SELECT ext, id');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
        try {
            $result = $stmt->executeStatement([]);
        } catch (\Doctrine\DBAL\Driver\Exception  $err){
            return $err->getMessage();
        }
        return $result;
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
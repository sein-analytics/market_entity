<?php

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;


class PayHistoryAttribute extends EntityRepository
    implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [];

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('PayHistoryAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 2018-12-20
 * Time: 13:19
 */

namespace App\Repository\Loan;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
class CommAttribute extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        'dscr' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'noi' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'net_worth_to_loan' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'profit_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'loan_to_cost_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'debt_yield_ratio' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL'],
        'vacancy_rate' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NULL']
    ];

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('CommAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        array_keys(self::$table);
    }
}
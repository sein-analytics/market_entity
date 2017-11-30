<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/6/17
 * Time: 1:32 PM
 */

namespace App\Repository;

use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;

class Deal extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchUserDealsFromIds(array $ids)
    {
        $sql = 'SELECT Deal.id, Deal.issuer_id, Deal.auction_type_id, Deal.asset_type_id, Deal.bid_type_id, Deal.issue, Deal.cut_off_date, Deal.closing_date, ' .
                'Deal.current_balance, Deal.views, ' .
                'MarketUser.first_name, MarketUser.last_name FROM Deal INNER JOIN MarketUser ON Deal.user_id = MarketUser.id ' .
                'WHERE Deal.status_id = 1 AND Deal.id IN (?) ORDER BY Deal.id ASC';
        $results = $this->fetchByIntArray($this->getEntityManager(), $ids, $sql);
        return $results;
    }

    /**
     * @return bool|\ReflectionClass
     */
    public function fetchRepositoryClass()
    {
        return $this->entityReflectorFromEntityName('App\Entity\Deal');
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Deal');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        $reflector = $this->entityReflectorFromEntityName('App\Entity\Deal');
        return $this->entityPropertiesFromReflector($reflector);
    }


}
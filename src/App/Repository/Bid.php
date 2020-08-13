<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/9/17
 * Time: 5:56 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class Bid
 * @package App\Repository
 */
class Bid extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;
    const BID_DEAL = "deal_id";
    const DD_STATUS = 4;
    const LOI_STATUS_1 = 3;
    const LOI_STATUS_2 = 7;
    const MLPA_STATUS_1 = 5;
    const MLPA_STATUS_2 = 10;
    const DD_KEY = 'dd';
    const LOI_KEY = 'loi';
    const MLPA_KEY = 'mlpa';

    /**
     * @param array $dealIds
     * @param bool $mapBidsToDeals
     * @return array
     */
    public function fetchBidsForDealIds(array $dealIds, $mapBidsToDeals = true)
    {
        $sql = 'SELECT * FROM Bid WHERE deal_id IN (?) ORDER BY deal_id ASC, id ASC';
        $results = $this->fetchByIntArray($this->getEntityManager(), $dealIds, $sql);
        if ($mapBidsToDeals
            && count($results ) > 0)
        {
            $results = $this->mapRequestIdsToResults($dealIds, $results, self::BID_DEAL);
        }
        return $results;
    }

    /**
     * @param int $dealId
     * @return float
     */
    public function fetchMaxBidByDealId(int $dealId)
    {
        $sql = "SELECT Max(price) as price FROM Bid WHERE deal_id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $dealId);
        $temp = $stmt->execute();
        $result = $stmt->fetch();
        if (count($result) == 1 && array_key_exists('price', $result)){
            return (float)$result['price'];
        }
        return 0.00;
    }

    /**
     * @param int $dealId
     * @param int $userId
     * @return array
     */
    public function fetchBidsByDealIdAndUserId(int $dealId, int $userId)
    {
        $sql = "SELECT * FROM Bid WHERE user_id = :user_id AND deal_id = :deal_id ORDER BY id ASC";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue('user_id', $userId);
        $stmt->bindValue('deal_id', $dealId);
        $temp = $stmt->execute();
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $result;
    }

    /**
     * @param int $dealId
     * @return float
     */
    public function fetchLastBidByDealId(int $dealId)
    {
        $sql = "SELECT price FROM Bid WHERE id IN (SELECT Max(id) FROM Bid WHERE deal_id = :deal_id)";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue('deal_id', $dealId);
        $temp = $stmt->execute();
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        if (is_array($result)
            && count($result) === 1
            && array_key_exists('price', $result)){
            return (float)$result['price'];
        }else{
            return 0.00;
        }
    }

    public function fetchDistinctDealIdsForDealsWithUserBids(int $userId)
    {
        $sql = "SELECT DISTINCT deal_id FROM Bid where user_id = ?";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $result = $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->flattenResultArrayByKey($result, 'deal_id');
    }

    function fetchDealDdCount (int $dealId)
    {
        $status = self::DD_STATUS;
        $key = self::DD_KEY;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE deal_id = :deal_id AND status_id = $status";
        return $this->returnRequestedCount($dealId, $sql, $key);
    }

    /**
     * @param int $dealId
     * @return \Exception|int
     */
    function fetchDealLoiCount (int $dealId)
    {
        $st1 = self::LOI_STATUS_1;
        $st2 = self::LOI_STATUS_2;
        $key = self::LOI_KEY;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE (status_id=$st1 or status_id=$st2) AND deal_id = :deal_id";
        return $this->returnRequestedCount($dealId, $sql, $key);
    }

    /**
     * @param int $dealId
     * @return \Exception|int
     */
    function fetchDealMlpaCount (int $dealId)
    {
        $st1 = self::MLPA_STATUS_1;
        $st2 = self::MLPA_STATUS_2;
        $key = self::MLPA_KEY;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE (status_id=$st1 or status_id=$st2) AND deal_id = :deal_id";
        return $this->returnRequestedCount($dealId, $sql, $key);
    }

    /**
     * @param int $dealId
     * @param string $sql
     * @param string $key
     * @return \Exception|int
     */
    protected function returnRequestedCount(int $dealId, string $sql, string $key)
    {
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $temp = $stmt->execute();
        } catch (\Exception $exception) {
            return $exception;
        }
        $stmt->bindValue('deal_id', $dealId);
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        if (array_key_exists($key, $result))
            return (int)$result[$key];
        return 0;
    }
}
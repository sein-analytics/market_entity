<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/9/17
 * Time: 5:56 PM
 */

namespace App\Repository;


use App\Repository\Bid\BidInterface;
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
    implements DbalStatementInterface, BidInterface
{
    use FetchMapperTrait, FetchingTrait;

    private $keepCountKey = false;

    private string $updateBidHistorySql = "UPDATE Bid SET bid_history=? WHERE id=?";

    private string $fetchIssuerActiveUserBids = "SELECT deal_id, user_id FROM Bid WHERE user_id IN (?) AND status_id >= 3";

    private string $updateBidStatusSql = "UPDATE Bid SET status_id=? WHERE id=?";

    private string $fetchBidByIdSql = "SELECT * FROM Bid WHERE id=?";

    private string $callFetchDealIssuersLoiActiveBids = 'call FetchDealIssuersLoiActiveBids(:dealId, :bidsStatusIds)';

    private string $fetchMaxPriceFromDealBidsSql = "SELECT Max(price) as price FROM Bid WHERE deal_id=?";

    private string $fetchUserBidsByDealSql = "SELECT * FROM Bid WHERE user_id=? AND deal_id=? ORDER BY id ASC";

    private string $fetchLastBidPriceByDealSql = "SELECT price FROM Bid WHERE id IN (SELECT Max(id) FROM Bid WHERE deal_id=?)";

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
            && is_array($results)
            && count($results ) > 0)
        {
            return $this->mapRequestIdsToResults($dealIds, $results, self::BID_DEAL);
        }
        return [];
    }

    /**
     * @param int $dealId
     * @return float
     */
    public function fetchMaxBidByDealId(int $dealId)
    {
        $price = 0.00;

        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchMaxPriceFromDealBidsSql,
            self::FETCH_ASSO_MTHD,
            [$dealId],
        );

        if (is_array($result)){
            $price = (float)$result['price'];
        }

        return $price;
    }

    /**
     * @param int $dealId
     * @param int $userId
     * @return array
     */
    public function fetchBidsByDealIdAndUserId(int $dealId, int $userId)
    {
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchUserBidsByDealSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userId, $dealId]
        );

        return $result;
    }

    /**
     * @param int $dealId
     * @return float
     */
    public function fetchLastBidByDealId(int $dealId)
    {
        $price = 0.00;

        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchLastBidPriceByDealSql,
            self::FETCH_ASSO_MTHD,
            [$dealId]
        );

        if (is_array($result) && array_key_exists('price', $result)){
            $price = (float)$result['price'];
        }

        return $price;
    }

    public function fetchDistinctDealIdsForDealsWithUserBids(int $userId)
    {
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            "SELECT DISTINCT deal_id FROM Bid where user_id=?",
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );

        return $this->flattenResultArrayByKey($result, 'deal_id');
    }

    /**
     * @param int $dealId
     * @param bool $keepKey
     * @return \Exception|int
     */
    function fetchDealDdCount (int $dealId, bool $keepKey=false)
    {
        $this->keepCountKey = $keepKey;
        $status = self::DD_STATUS;
        $key = self::BID_DD_KEY;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE status_id=$status AND deal_id=?";
        return $this->returnRequestedCount($dealId, $sql, $key);
    }

    /**
     * @param int $dealId
     * @param bool $keepKey
     * @return \Exception|int
     */
    function fetchDealLoiCount (int $dealId, bool $keepKey= false)
    {
        $st1 = self::LOI_STATUS_1;
        $st2 = self::LOI_STATUS_2;
        $key = self::BID_LOI_KEY;
        $this->keepCountKey = $keepKey;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE (status_id=$st1 or status_id=$st2) AND deal_id=?";
        return $this->returnRequestedCount($dealId, $sql, $key);
    }

    /**
     * @param int $dealId
     * @param bool $keepKey
     * @return \Exception|int
     */
    function fetchDealMlpaCount (int $dealId, bool $keepKey=false)
    {
        $st1 = self::MLPA_STATUS_1;
        $st2 = self::MLPA_STATUS_2;
        $key = self::BID_MLPA_KEY;
        $this->keepCountKey = $keepKey;
        $sql = "SELECT COUNT(*) AS $key FROM Bid WHERE (status_id=$st1 or status_id=$st2) AND deal_id=?";
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
        $count = 0;

        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::FETCH_ASSO_MTHD,
            [$dealId]
        );

        if (is_array($result) && array_key_exists($key, $result)) {
            $count = !$this->keepCountKey ? (int)$result[$key] : $result;
        }

        return $count;
    }

    public function updateLoggerByStatusId(int $id, array $history):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateBidHistorySql,
            self::EXECUTE_MTHD,
            [json_encode($history), $id]
        );
    }

    public function fetchIssuerActiveUserBids(array $userIds):mixed
    {
        try {
            return $this->buildAndExecuteIntArrayStmt(
                $this->getEntityManager(),
                $this->fetchIssuerActiveUserBids,
                self::FETCH_ALL_ASSO_MTHD,
                $userIds
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateBidStatus(int $statusId, int $bidId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateBidStatusSql,
            self::EXECUTE_MTHD,
            [$statusId, $bidId]
        );
    }

    public function updateMultiBidStatuses(int $statusId, array $bidIds): mixed
    {
        return $this->buildAndExecuteIntArrayStmt(
            $this->getEntityManager(),
            "UPDATE Bid SET status_id=$statusId IN (?)",
            self::EXECUTE_MTHD,
            $bidIds
        );
    }

    public function fetchBidByIdSql(int $bidId): mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchBidByIdSql,
            self::FETCH_ASSO_MTHD,
            [$bidId]
        );
    }

    public function fetchDealIssuersLoiActiveBids(int $dealId, array $bidsStatusIds):mixed
    {
        return $this->executeProcedure([$dealId, implode(', ', $bidsStatusIds)],
            $this->callFetchDealIssuersLoiActiveBids);
    }

}
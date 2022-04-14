<?php

namespace App\Repository;

use App\Repository\Community\CommunityAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use function Lambdish\phunctional\{each};
class Community extends CommunityAbstract
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static $table = [
        self::COMM_DB_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_OWNER_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_NAME_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_DES_KEY => [self::DATA_TYPE => 'longtext', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_DATE_KEY => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_PRMRY_KEY => [self::DATA_TYPE => 'tinyint', self::DATA_DEFAULT => 'NOT NULL'],
        self::COMM_DB_AVATAR_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL'],
        self::COMM_DB_UUID_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL']
    ];

    /**
     * @param int $userId
     * @return array[]
     */
    public function fetchUserCommunityProfiles (int $userId):array
    {
        return [
            self::COMM_PROFILES_KEY => [
                self::COMM_SELLERS_KEY => $this->executeProcedure(
                    $this->returnUserProfilesParams($userId, self::COMM_SELLERS_KEY),
                    self::$callCommProfilesByBidAndRoles),
                self::COMM_BUYERS_KEY => $this->executeProcedure(
                    $this->returnUserProfilesParams($userId, self::COMM_BUYERS_KEY),
                    self::$callCommProfilesByBidAndRoles)
            ]
        ];
    }

    /**
     * @param int $userId
     * @return array[]
     */
    public function fetchUserCommunities(int $userId):array
    {
        $results = $this->executeProcedure([$userId], self::$callCommunitiesByUserId);
        if (count($results) > 0){
            each(function ($result, $key) use(&$results, $userId){
                $userIds = $this->fetchCommunityGroupUserIds(
                    (int)$result[self::COMM_DB_ID_KEY], $userId);
                if (is_array($userIds) && count($userIds) > 0){
                    $results[$key][self::COMM_BUYERS_KEY] = $this->executeProcedure(
                        $this->returnCommunityProfilesParams($userIds, self::COMM_BUYERS_KEY),
                        self::$callCommProfilesByUserIdsBidAndRoles
                    );
                    $results[$key][self::COMM_SELLERS_KEY] = $this->executeProcedure(
                        $this->returnCommunityProfilesParams($userIds, self::COMM_SELLERS_KEY),
                        self::$callCommProfilesByUserIdsBidAndRoles
                    );
                }
            }, $results);
        }
        return [self::COMM_GROUPS_KEY => $results];
    }

    public function fetchCommunityGroupUserIds (int $commId, $userId)
    {
        return $this->buildAndExecuteFromSql(
            $this->em, self::$communityUserIdsSql, self::FETCH_NUMERIC_MTHD, [$commId, $userId]
        );
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserRecentSales(int $userId)
    {
        return $this->executeProcedure([$userId], self::$callCommunityRecentSales);
    }

    public function fetchUserRecentPurchases(int $userId)
    {
        return $this->executeProcedure([$userId], self::$callCommunityRecentPurchases);
    }

    public function fetchMarketSpecialities ()
    {
        return $this->buildAndExecuteFromSql($this->em,
            self::FETCH_SPECIALITIES_SQL, self::FETCH_ALL_ASSO_MTHD, []
        );
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Community');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}
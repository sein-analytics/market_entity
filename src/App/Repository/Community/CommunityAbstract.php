<?php
namespace App\Repository\Community;
use App\Repository\DbalStatementInterface;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping;

abstract class CommunityAbstract extends EntityRepository
    implements CommunityInterface, DbalStatementInterface, SqlManagerTraitInterface
{

    protected static string $callCommProfilesByBidAndRoles = 'call CommunityProfilesByBidStatusAndUserRole(:bidStatusIds, :roleIds, :userId)';

    protected static string $callCommProfilesByUserIdsBidAndRoles = 'call CommunityProfilesByUserBidStatusAndRole(:bidStatusIds, :roleIds, :userIds)';

    protected static string $callCommunityRecentPurchases = 'call CommunityRecentPurchases(:userId)';

    protected static string $callUserRatingsDist = 'call UserRatingsDist(:userId)';

    protected static string $callProfileCallReportData = 'call ProfileCallReportData(:issuerId)';

    protected static string $callCommunityRecentSales = 'call CommunityRecentSales(:userId)';

    protected static string $communityUserIdsSql = 'SELECT user_id FROM user_communities WHERE comm_id=? AND user_id !=?';

    protected static string $createCommunitySql = 'INSERT INTO Community VALUE (0, ?, ?, ?, ?, ?, ?, ?)';

    protected static string $addUserToGroup = 'INSERT INTO user_communities VALUE (?, ?)';

    protected static string $deleteUserFromGroup = 'DELETE FROM user_communities WHERE comm_id=? and user_id=?';

    protected static string $addToFollowingSql = 'INSERT INTO following VALUE (?, ?)';

    protected static string $removeFromFollowingSql = 'DELETE FROM following WHERE user_id=? AND followin_id=?';

    protected static string $callCommunitiesByUserId = 'call CommunitiesByUserId(:userId)';

    protected static string $callCommunityUserRecentPurchases = 'call CommunityUserRecentPurchases(:userId, :communityUserId, :communityIssuerId)';

    protected static string $callCommunityUserRecentSales = 'call CommunityUserRecentSales(:userId, :communityUserId, :communityIssuerId)';

    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    public function returnCommunityBaseArray ():array
    {
        return [
            self::COMM_BUYERS_KEY => null,
            self::COMM_SELLERS_KEY => null
        ];
    }

    /**
     * @param int $userId
     * @param string $role
     * @return array|bool
     */
    public function returnUserProfilesParams (int $userId, string $role)
    {
        if (!$this->isRollKeyAppropriate($role))
            return false;
        return [
            self::COMM_CLOSE_STATUS_STR_ARR,
            ($role === self::COMM_BUYERS_KEY ? self::BUYER_ROLES_STR_ARR : self::SELLER_ROLES_STR_ARR),
            $userId
        ];
    }

    /**
     * @param array $userIds
     * @param string $role
     * @return array|false
     */
    public function returnCommunityProfilesParams(array $userIds, string $role)
    {
        if (!$this->isRollKeyAppropriate($role))
            return false;
        return [
            self::COMM_ALL_STATUS_STR_ARR,
            ($role === self::COMM_BUYERS_KEY ? self::BUYER_ROLES_STR_ARR : self::SELLER_ROLES_STR_ARR),
            implode(', ', $userIds)
        ];
    }

    /**
     * @param string $role
     * @return bool
     */
    protected function isRollKeyAppropriate(string $role):bool
    {
        if ($role !== self::COMM_BUYERS_KEY
            && $role !== self::COMM_SELLERS_KEY)
            return false;
        return true;
    }

}
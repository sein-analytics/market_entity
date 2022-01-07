<?php
namespace App\Repository\MarketUser;

use Doctrine\ORM\EntityRepository;

abstract class abstractMktUser extends EntityRepository
implements MktUserInterface
{
    private static $userDealIdsSql = 'SELECT deal_id FROM deal_market_user WHERE  market_user_id = ?';

    private static $usrWatchlistIdsSql = 'SELECT favorite_deal_id FROM user_favorite_deals WHERE  user_id = ?"';

    private static $rmvFromWatchlistSql = 'DELETE FROM user_favorite_deals WHERE user_id=? AND `favorite_deal_id`=?';

    private static $addToWatchlistSql = 'INSERT INTO user_favorite_deals (`user_id`, `favorite_deal_id`) VALUES (?,?)';

    private static $usersFromIdsArrSql = 'SELECT * FROM MarketUser WHERE id IN (?) ORDER BY id ASC';

    private static $buyerIdsByRoleSql = "SELECT id FROM AclRole WHERE role='Buyer' OR role='Both'";

    private static $userIdsByRoleIdSql = "SELECT id FROM MarketUser WHERE role_id in (?) ORDER BY id ASC ";

    private static $userSaltByEmailSql = "SELECT user_salt FROM MarketUser WHERE email = ? ";

    private static $usrIdByIssuerIdSql = "SELECT id FROM MarketUser WHERE issuer_id = ? AND id != ? ORDER BY id ASC ";

    private static $insertMsgIdUsrIdSql = "INSERT INTO `market_user_message` (`message_id`, `market_user_id`) VALUES (?, ?) ";

    private static $teamLeadIdFromUsrIdAndIssuerSql = "SELECT id from MarketUser m1 " .
        "WHERE m1.issuer_id = (SELECT issuer_id FROM MarketUser WHERE id = ?)";

    private static $updateRemTokenByUsrIdSql = "UPDATE `MarketUser` SET `remember_token`= ? WHere id= ?";

    private static $updateAuthTokenByUsrIdSql = "UPDATE `MarketUser` SET `authy_token`= ? WHere id= ?";

    protected $callUsersUuidsFromIds = 'call UsersUuidsFromIds(:userIds)';

    /** @return string */
    public static function getUserDealIdsSql(): string
    { return self::$userDealIdsSql; }

    /** @return string */
    public static function getUsrWatchlistIdsSql(): string
    { return self::$usrWatchlistIdsSql; }

    /** @return string */
    public static function getRmvFromWatchlistSql(): string
    { return self::$rmvFromWatchlistSql; }

    /** @return string */
    public static function getAddToWatchlistSql(): string
    { return self::$addToWatchlistSql; }

    /** @return string */
    public static function getUsersFromIdsArrSql(): string
    { return self::$usersFromIdsArrSql; }

    /** @return string */
    public static function getBuyerIdsByRoleSql(): string
    { return self::$buyerIdsByRoleSql; }

    /** @return string */
    public static function getUserIdsByRoleIdSql(): string
    { return self::$userIdsByRoleIdSql; }

    /** @return string */
    public static function getUserSaltByEmailSql(): string
    { return self::$userSaltByEmailSql; }

    /** @return string */
    public static function getUsrIdByIssuerIdSql(): string
    { return self::$usrIdByIssuerIdSql; }

    /** @return string */
    public static function getInsertMsgIdUsrIdSql(): string
    { return self::$insertMsgIdUsrIdSql; }

    /** @return string */
    public static function getTeamLeadIdFromUsrIdAndIssuerSql(): string
    { return self::$teamLeadIdFromUsrIdAndIssuerSql; }

    /** @return string */
    public static function getUpdateRemTokenByUsrIdSql(): string
    { return self::$updateRemTokenByUsrIdSql; }

    /** @return string */
    public static function getUpdateAuthTokenByUsrIdSql(): string
    { return self::$updateAuthTokenByUsrIdSql; }


}
<?php


namespace App\Repository;


use App\Repository\Chat\ChatAbstract;
use App\Repository\Chat\ChatInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function Lambdish\phunctional\{each};

class Chat extends ChatAbstract
    implements ChatInterface
{
    use FetchingTrait, FetchMapperTrait;

    protected string $callContactTrackIds = 'call UserContactsChatTrackerIds(:userId)';

    protected string $callUserContactChatVerifyTrackerId = 'call UserContactChatVerifyTrackerId(:userId, :trackerId)';
    
    protected string $callGroupChatVerifyTrackerId = 'call GroupChatVerifyTrackerId(:userId, :groupId, :trackerId)';

    protected string $callGroupTrackIds = 'call UserGroupChatTrackerIds(:userId)';

    protected string $callChatDataByTrackId = 'call ChatDataFromTrackerId(:trackerId, :tempDb, :offsetNum)';

    protected string $callChatGroupUsersByGroupId = 'call ChatGroupUsersByGroupId(:groupId)';

    protected string $callChatGroupDataFromGroupId = 'call ChatGroupDataFromGroupId(:groupId)';

    protected string $callNoChatUserIds = 'call NoChatUserIds(:userId, :chatUserIds)';

    protected string $callUserDataForChat = 'call UserDataForChat(:userId)';

    protected string $callChatRecipientDataFromTrackerId = 'call ChatRecipientDataFromTrackerId(:trackerId, :searchKey)';
    
    protected string $callMarketUsersFromSearchKey = 'call MarketUsersFromSearchKey(:searchKey, :userId)';

    protected string $callGroupsFromSearchKey = 'call GroupsFromSearchKey(:userId, :searchKey)';
    
    protected string $callChatMembersFromTrackerId = 'call ChatMembersFromTrackerId(:trackerId)';

    protected string $callChatMembersFromTrackerIds = 'call ChatMembersFromTrackerIds(:trackerIds)';

    protected string $callGroupMembersFromTrackerId = 'call GroupMembersFromTrackerId(:trackerId)';

    protected string $callGroupMembersFromTrackerIds = 'call GroupMembersFromTrackerIds(:trackerIds)';

    private string $insertIntoChatSql = "insert into Chat value (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $insertNewChatSql = 'insert into Chat (`id`, `user_id`, `recipient_id`, `group_id`, `message`, `message_date`, `attachments`, `tracker_id`, `contact_id`, `status_id`, `is_group`) ';
    
    private string $insertIntoFollowersSql = "insert into followers value (?, ?)";
    
    private string $insertIntoFollowingSql = "insert into following value (?, ?)";
    
    private string $insertIntoChatSqlBase = 'insert into Chat (`id`, `user_id`, `recipient_id`, `group_id`, `message`, `message_date`, `attachments`, `tracker_id`, `contact_id`, `status_id`, `is_group`) ';

    /**`
     * @param array $params
     * @return \Exception|mixed
     */
    public function insertNewChat(array $params): mixed
    {
        if (array_key_exists(self::QRY_ID_KEY, $params))
            unset($params[self::QRY_ID_KEY]);
        
        $sql = $this->insertNewChatSql . 'VALUE (null,'
            . $params[self::QRY_USER_ID_KEY] . ','
            . $params[self::QRY_RECIPIENT_ID_KEY] . ','
            . $params[self::QRY_GROUP_ID_KEY] . ','
            . $params[self::CHAT_MSG_MSG_KEY] . ','
            . '"' . $params[self::QRY_MSG_DATE_KEY] . '",'
            . $params[self::QRY_MSG_FILES_KEY] . ','
            . $params[self::QRY_TRACKER_ID_KEY] . ','
            . $params[self::QRY_CONTACT_ID_KEY] . ','
            . $params[self::QRY_STATUS_ID_KEY] . ','
            . $params[self::QRY_IS_GROUP_KEY] . ');';
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            []
        );
    }

    /**`
     * @param array $params
     * @return \Exception|mixed
     */
    public function insertNewFollowers(array $params): mixed
    {
        if (array_key_exists("user_id", $params) && array_key_exists("follower_id", $params)) {
            $sql = "insert into followers values (" . $params["user_id"] . ", " . $params["follower_id"] . "), (" . $params["follower_id"] . ", " . $params["user_id"] . ");";
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            []
        );
    }

    /**`
     * @param array $params
     * @return \Exception|mixed
     */
    public function insertNewFollowings(array $params): mixed
    {
        if (array_key_exists("user_id", $params) && array_key_exists("following_id", $params)) {
            $sql = "insert into following values (" . $params["user_id"] . ", " . $params["following_id"] . "), (" . $params["following_id"] . ", " . $params["user_id"] . ");";
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            []
        );
    }

    /**
     * @param array $params
     * @param array $userIds
     * @return \Exception|mixed
     */
    public function insertNewChatToGroup(array $params, array $userIds): mixed
    {
        $base = $this->insertIntoChatSqlBase;
        
        $sql = $base . 'VALUES ';
        $count = 1;
        each(function ($userId) use(&$sql, &$count, $params, $userIds) {
            $sql = $sql . PHP_EOL . "(null, " . (int)$userId . ', ' . $params["recipient_id"] . ', ' . (int)$params["group_id"] . ', ' . $params["message"] . ', "' . date('Y-m-d H:i:s') . '", ' . $params["attachments"] . ', ' . (int)$params["tracker_id"] . ', ' . $params["contact_id"] . ', ' . $params["status_id"] . ', ' . (int)$params["is_group"] . ')' . ($count === count($userIds) ? ';' : ',');
            $count++;
        }, $userIds);
        return [
            "sql" => $sql,
            "result" => $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $sql,
                self::EXECUTE_MTHD,
                []
            ),
        ];
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserContactChatTrackerIds(int $userId):mixed
    {
        return $this->executeProcedure([$userId], $this->getCallContactTrackIds());
    }

    /**
     * @param int $userId
     * @param int $trackerId
     * @return mixed
     */
    public function fetchUserContactChatVerifyTrackerId(int $userId, int $trackerId):mixed
    {
        return $this->executeProcedure([$userId, $trackerId], $this->getCallUserContactChatVerifyTrackerId());
    }
    
    /**
     * @param int $userId
     * @param int $trackerId
     * @return mixed
     */
    public function fetchGroupChatVerifyTrackerId(int $userId, int $groupId, int $trackerId):mixed
    {
        return $this->executeProcedure([$userId, $groupId, $trackerId], $this->getCallGroupChatVerifyTrackerId());
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserGroupChatTrackerIds(int $userId):mixed
    {
        return $this->executeProcedure([$userId], $this->getCallGroupTrackIds());
    }

    /**
     * @param int $trackerId
     * @param int $offset
     * @return mixed
     */
    public function fetchChatDataByTrackerId(int $trackerId, int $offset=0):mixed
    {
        $uuid = 'dbName' . Str::uuid()->getHex()->toString();
        return $this->executeProcedure([$trackerId, $uuid, $offset],
            $this->getCallChatDataByTrackId());
    }

    /**
     * @param int $groupId
     * @return mixed
     */
    public function fetchChatGroupUsersByGroupId(int $groupId):mixed {
        return $this->executeProcedure([$groupId], $this->getCallChatGroupUsersByGroupId());
    }

    /**
     * @param int $groupId
     * @return mixed
     */
    public function fetchChatGroupData(int $groupId):mixed {
        return $this->executeProcedure([$groupId], $this->getCallChatGroupDataFromGroupId());
    }

    /**
     * @param int $userId
     * @param array $chatUserIds
     * @return mixed
     */
    public function fetchContactIdsWithNoChats(int $userId, array $chatUserIds):mixed {
        return $this->executeProcedure([$userId, implode(', ', $chatUserIds)],
            $this->getCallNoChatUserIds()
        );
    }

    /**
     * @param array $userIds
     * @return mixed
     */
    public function fetchChatDataForUserIds(array $userIds):mixed {
        return $this->executeProcedure([implode(', ', $userIds)],
            $this->getCallUserDataForChat()
        );
    }

    /**
     * @param int $userId
     * @param int $contactId
     * @return \Exception|mixed
     */
    public function fetchTrackerIdForUserContact(int $userId, int $contactId):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::TRACKER_BY_CONTACT_AND_USER_ID,
            self::FETCH_ONE_MTHD,
            [$contactId, $userId, $contactId, $userId]
        );
    }

    public function contactDataFromChatTrackerId (int $chatId, string $searchKey)
    {
        return $this->executeProcedure([$chatId, $searchKey],
            $this->getCallChatRecipientDataFromTrackerId()
        );
    }

    public function marketUsersDataFromSearchKey(string $searchKey, int $userId)
    {
        return $this->executeProcedure([$searchKey, $userId],
            $this->getCallMarketUsersFromSearchKey()
        );
    }

    public function groupsDataFromSearchKey(int $userId, string $searchKey)
    {
        return $this->executeProcedure([$userId, $searchKey],
            $this->getCallGroupsFromSearchKey()
        );
    }

    public function chatMembersFromTrackerId (int $chatId)
    {
        return $this->executeProcedure([$chatId],
            $this->getCallChatMembersFromTrackerId()
        );
    }

    public function chatMembersFromTrackerIds (array $chatIds)
    {
        $trackerIds = implode(',', $chatIds);
        return $this->executeProcedure([$trackerIds],
            $this->getCallChatMembersFromTrackerIds()
        );
    }

    public function groupMembersFromTrackerId (int $chatId)
    {
        return $this->executeProcedure([$chatId],
            $this->getCallGroupMembersFromTrackerId()
        );
    }

    public function groupMembersFromTrackerIds (array $chatIds)
    {
        $trackerIds = implode(',', $chatIds);
        return $this->executeProcedure([$trackerIds],
            $this->getCallGroupMembersFromTrackerIds()
        );
    }

    /**
     * @return string
     */
    public function getCallContactTrackIds(): string { return $this->callContactTrackIds; }
    
    /**
     * @return string
     */
    public function getCallUserContactChatVerifyTrackerId(): string { return $this->callUserContactChatVerifyTrackerId; }
    
    /**
     * @return string
     */
    public function getCallGroupChatVerifyTrackerId(): string { return $this->callGroupChatVerifyTrackerId; }

    /**
     * @return string
     */
    public function getCallGroupTrackIds(): string { return $this->callGroupTrackIds; }

    /**
     * @return string
     */
    public function getCallChatDataByTrackId(): string { return $this->callChatDataByTrackId; }

    /**
     * @return string
     */
    public function getCallChatGroupUsersByGroupId(): string { return $this->callChatGroupUsersByGroupId; }

    /**
     * @return string
     */
    public function getCallChatGroupDataFromGroupId(): string { return $this->callChatGroupDataFromGroupId; }

    /**
     * @return string
     */
    public function getCallNoChatUserIds(): string { return $this->callNoChatUserIds; }

    /**
     * @return string
     */
    public function getCallUserDataForChat(): string { return $this->callUserDataForChat; }

    /**
     * @return string
     */
    public function getCallChatRecipientDataFromTrackerId(): string {
        return $this->callChatRecipientDataFromTrackerId;
    }

    /**
     * @return string
     */
    public function getCallMarketUsersFromSearchKey(): string {
        return $this->callMarketUsersFromSearchKey;
    }

    /**
     * @return string
     */
    public function getCallGroupsFromSearchKey(): string {
        return $this->callGroupsFromSearchKey;
    }

    /**
     * @return string
     */
    public function getCallChatMembersFromTrackerId(): string {
        return $this->callChatMembersFromTrackerId;
    }

    public function getCallChatMembersFromTrackerIds(): string {
        return $this->callChatMembersFromTrackerIds;
    }

    /**
     * @return string
     */
    public function getCallGroupMembersFromTrackerId(): string {
        return $this->callGroupMembersFromTrackerId;
    }

    public function getCallGroupMembersFromTrackerIds(): string {
        return $this->callGroupMembersFromTrackerIds;
    }


}
<?php


namespace App\Repository;


use App\Repository\Chat\ChatAbstract;
use App\Repository\Chat\ChatInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class Chat extends ChatAbstract
    implements ChatInterface
{
    use FetchingTrait, FetchMapperTrait;

    protected $callContactTrackIds = 'call UserContactsChatTrackerIds(:userId)';

    protected $callGroupTrackIds = 'call UserGroupChatTrackerIds(:userId)';

    protected $callChatDataByTrackId = 'call ChatDataFromTrackerId(:trackerId, :tempDb, :offsetNum)';

    protected $callChatGroupUsersByGroupId = 'call ChatGroupUsersByGroupId(:groupId)';

    protected $callChatGroupDataFromGroupId = 'call ChatGroupDataFromGroupId(:groupId)';

    protected $callNoChatUserIds = 'call NoChatUserIds(:userId, :chatUserIds)';

    protected $callUserDataForChat = 'call UserDataForChat(:userId)';

    protected $callChatRecipientDataFromTrackerId = 'call ChatRecipientDataFromTrackerId(:trackerId)';

    private $insertIntoChatSql = "insert into Chat value (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    /**
     * @param array $params
     * @return \Exception|mixed
     */
    public function insertNewChat(array $params)
    {
        if (array_key_exists(self::QRY_ID_KEY, $params))
            unset($params[self::QRY_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertIntoChatSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserContactChatTrackerIds(int $userId)
    {
        return $this->executeProcedure([$userId], $this->getCallContactTrackIds());
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserGroupChatTrackerIds(int $userId)
    {
        return $this->executeProcedure([$userId], $this->getCallGroupTrackIds());
    }

    /**
     * @param int $trackerId
     * @param int $offset
     * @return mixed
     */
    public function fetchChatDataByTrackerId(int $trackerId, int $offset=0)
    {
        $uuid = 'dbName' . Str::uuid()->getHex()->toString();
        return $this->executeProcedure([$trackerId, $uuid, $offset],
            $this->getCallChatDataByTrackId());
    }

    /**
     * @param int $groupId
     * @return mixed
     */
    public function fetchChatGroupUsersByGroupId(int $groupId){
        return $this->executeProcedure([$groupId], $this->getCallChatGroupUsersByGroupId());
    }

    /**
     * @param int $groupId
     * @return mixed
     */
    public function fetchChatGroupData(int $groupId){
        return $this->executeProcedure([$groupId], $this->getCallChatGroupDataFromGroupId());
    }

    /**
     * @param int $userId
     * @param array $chatUserIds
     * @return mixed
     */
    public function fetchContactIdsWithNoChats(int $userId, array $chatUserIds) {
        return $this->executeProcedure([$userId, implode(', ', $chatUserIds)],
            $this->getCallNoChatUserIds()
        );
    }

    /**
     * @param array $userIds
     * @return mixed
     */
    public function fetchChatDataForUserIds(array $userIds) {
        return $this->executeProcedure([implode(', ', $userIds)],
            $this->getCallUserDataForChat()
        );
    }

    /**
     * @param int $userId
     * @param int $contactId
     * @return \Exception|mixed
     */
    public function fetchTrackerIdForUserContact(int $userId, int $contactId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::TRACKER_BY_CONTACT_AND_USER_ID,
            self::FETCH_ONE_MTHD,
            [$contactId, $userId, $contactId, $userId]
        );
    }

    /**
     * @param string $uuid
     * @return array|false|mixed|string
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function fetchUserTrackerIdByUuid (string $uuid)
    {
        $sql = "SELECT id FROM ChatTracker WHERE uuid = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->bindValue(1, $uuid);
            return $stmt->fetchNumeric();
        }catch (\Exception $exception){
            $msg = "Error fetching id for uuid: " . $exception->getMessage();
            Log::critical($msg);
            return $msg;
        }
    }

    public function contactDataFromChatTrackerId (int $chatId)
    {
        return $this->executeProcedure([$chatId],
            $this->getCallChatRecipientDataFromTrackerId()
        );
    }

    /**
     * @return string
     */
    public function getCallContactTrackIds(): string { return $this->callContactTrackIds; }

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


}
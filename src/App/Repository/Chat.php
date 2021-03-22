<?php


namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class Chat extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    protected $callContactTrackIds = 'call UserContactsChatTrackerIds(:userId)';

    protected $callGroupTrackIds = 'call UserGroupChatTrackerIds(:userId)';

    protected $callChatDataByTrackId = 'call ChatDataFromTrackerId(:trackerId, :tempDb, :offsetNum)';

    protected $callChatGroupUsersByGroupId = 'call ChatGroupUsersByGroupId(:groupId)';

    protected $callChatGroupDataFromGroupId = 'call ChatGroupDataFromGroupId(:groupId)';

    protected $callNoChatUserIds = 'NoChatUserIds(:userId, :chatUserIds)';

    protected $callUserDataForChat = 'UserDataForChat(:userId)';

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

    public function fetchChatDataByTrackerId(int $trackerId, int $offset=0)
    {
        $uuid = 'dbName-' . Str::uuid()->getHex()->toString();
        return $this->executeProcedure([$trackerId, $uuid, $offset],
            $this->getCallChatDataByTrackId());
    }

    public function fetchChatGroupUsersByGroupId(int $groupId){
        return $this->executeProcedure([$groupId], $this->getCallChatGroupUsersByGroupId());
    }

    public function fetchChatGroupData(int $groupId){
        return $this->executeProcedure([$groupId], $this->getCallChatGroupDataFromGroupId());
    }

    public function fetchContactIdsWithNoChats(int $userId, array $chatUserIds) {
        return $this->executeProcedure([$userId, implode(',', $chatUserIds)],
            $this->getCallNoChatUserIds()
        );
    }

    public function fetchChatDataForUserIds(array $userIds) {
        return $this->executeProcedure([implode(',', $userIds)],
            $this->getCallUserDataForChat()
        );
    }

    protected function executeProcedure(array $params, string $procedure)
    {
        return json_decode(
            json_encode(DB::select($procedure, $params)),
            true
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


}
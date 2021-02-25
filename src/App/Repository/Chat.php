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

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserContactChatTrackerIds(int $userId)
    {
        return json_decode(
            json_encode(DB::select($this->getCallContactTrackIds(), [$userId])),
            true
        );
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function fetchUserGroupChatTrackerIds(int $userId)
    {
        return json_decode(
            json_encode(DB::select($this->getCallGroupTrackIds(), [$userId])),
            true
        );
    }

    public function fetchChatDataByTrackerId(int $trackerId, int $offset=0)
    {
        $uuid = 'dbName-' . Str::uuid()->getHex()->toString();
        return json_decode(
            json_encode(DB::select($this->getCallChatDataByTrackId(), [$trackerId, $uuid, $offset])),
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

}
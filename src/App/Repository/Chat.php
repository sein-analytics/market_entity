<?php


namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\DB;

class Chat extends EntityRepository
{
    use FetchingTrait, FetchMapperTrait;

    protected $callContactTrackIds = 'call UserContactsChatTrackerIds(:userId)';

    protected $callGroupTrackIds = 'call UserGroupChatTrackerIds(:userId)';

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

    /**
     * @return string
     */
    public function getCallContactTrackIds(): string { return $this->callContactTrackIds; }

    /**
     * @return string
     */
    public function getCallGroupTrackIds(): string { return $this->callGroupTrackIds; }



}
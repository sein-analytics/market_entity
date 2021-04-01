<?php


namespace App\Repository;

use App\Repository\Chat\ChatAbstract;
use App\Repository\Chat\ChatGroupInterface;
use App\Repository\RepositoryException;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupChat extends ChatAbstract
    implements ChatGroupInterface
{
    use FetchingTrait, FetchMapperTrait;

    protected $insertIntoChatGroupSql = "insert into ChatGroup (`id`, `user_id`, `uuid`, `group_name`, `is_private`,".
                "`community_id`, `image_url`, `tracker_id`) value (NULL, ?, ?, ?, ?, ?, ?, ?)";

    protected $selectFromChatGroupByUserIdSql = "SELECT ? FROM ChatGroup WHERE user_id = ?";

    protected $selectIdFromChatGroupByUuidSql = "SELECT id FROM ChatGroup WHERE uuid = ?";

    protected $callUniqueGroupIdByUserIds = 'call UniqueGroupIdByUserIds(:userId, :chatUserIds, :tempDb1, :tempDb2)';

    public function fetchUniqueGroupIdByUserIds(array $userIds, int $userId)
    {
        if (!in_array($userId, $userIds))
            array_push($userIds, $userId);
        return json_decode(
            json_encode(DB::select($this->callUniqueGroupIdByUserIds,
                [ $userId, implode(', ', $userIds),
                  'dbName' . Str::uuid()->getHex()->toString(),
                  'dbName' . Str::uuid()->getHex()->toString()
                ])
            ),
            true
        );
    }

    public function addUsersToChatGroup(int $groupId, array $userIds)
    {}

    public function removeUserFromChatGroup()
    {}

    public function insertNewChatGroupReturnId(array $params)
    {
        unset($params[self::GROUP_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertIntoChatGroupSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    /**
     * @param string $uuid
     * @return \Exception|mixed
     */
    public function fetchGroupIdByGroupUuid(string $uuid)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::FETCH_CHAT_GROUP_DATA_SQL[self::GROUP_ID_BY_UUID],
            self::FETCH_ONE_MTHD,
            [$uuid]
        );
    }

    /**
     * @param string $uuid
     * @return \Exception|mixed
     */
    public function fetchGroupDataByGroupUuid(string $uuid)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::FETCH_CHAT_GROUP_DATA_SQL[self::GROUP_ALL_BY_UUID],
            self::FETCH_ASSO_MTHD,
            [$uuid]
        );
    }

    /**
     * @param int $userId
     * @return \Exception|mixed
     */
    public function fetchGroupIdByUserId(int $userId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::FETCH_CHAT_GROUP_DATA_SQL[self::GROUP_ID_BY_USER_ID],
            self::FETCH_ONE_MTHD,
            [$userId]
        );
    }

    /**
     * @param int $userId
     * @return \Exception|mixed
     */
    public function fetchGroupDataByUserId(int $userId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::FETCH_CHAT_GROUP_DATA_SQL[self::GROUP_ALL_BY_USER_ID],
            self::FETCH_ASSO_MTHD,
            [$userId]
        );
    }

    public function updateChatGroupByUuid(string $uuid, string $field, $value)
    {
        if (!array_key_exists($field, self::GROUP_CHAT_UPDATES_SQL_BY_UUID))
            throw $this->getRepoException()::generalIssueError("Property $field cannot be updated or does not exist");
        if(($id = $this->fetchGroupIdByGroupUuid($uuid)) instanceof \Exception)
            return $id;
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::GROUP_CHAT_UPDATES_SQL_BY_UUID[$field],
            self::EXECUTE_MTHD,
            [$value, $uuid]
        );
    }

    public function updateChatGroupById(int $id, string $field, $value)
    {
        if (!array_key_exists($field, self::GROUP_CHAT_UPDATES_SQL_BY_ID))
            throw $this->getRepoException()::generalIssueError("Property $field cannot be updated or does not exist");
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::GROUP_CHAT_UPDATES_SQL_BY_ID[$field],
            self::EXECUTE_MTHD,
            [$value, $id]
        );
    }


}
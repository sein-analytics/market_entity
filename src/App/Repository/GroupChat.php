<?php


namespace App\Repository;

use App\Repository\Chat\ChatAbstract;
use App\Repository\Chat\ChatGroupInterface;
use App\Repository\RepositoryException;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Lambdish\phunctional\{each};

class GroupChat extends ChatAbstract
    implements ChatGroupInterface
{
    use FetchingTrait, FetchMapperTrait;

    private $insertIntoChatGroupSql = "insert into ChatGroup (`id`, `user_id`, `uuid`, `group_name`, `is_private`,".
                "`community_id`, `image_url`, `tracker_id`) value (NULL, ?, ?, ?, ?, ?, ?, ?)";

    private $insertGroupUsersSqlBase = 'insert into chat_group_market_users (`group_chat_id`, `market_user_id`) ';

    private $deleteGroupUsersSqlBase = 'DELETE from chat_group_market_users WHERE `market_user_id` = ? and `group_chat_id` = ?';

    protected $callUniqueGroupIdByUserIds = 'call UniqueGroupIdByUserIds(:userId, :chatUserIds, :tempDb1, :tempDb2)';

    /**
     * @param array $userIds
     * @param int $userId
     * @return mixed
     */
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

    /**
     * @param int $groupId
     * @param array $userIds
     * @return \Exception|mixed
     */
    public function addUsersToChatGroup(int $groupId, array $userIds)
    {
        $base = $this->insertGroupUsersSqlBase;
        if (count($userIds) == 1)
            $sql = $base . "VALUE (" . (int)$groupId . ', ' . (int)$userIds[0] . ');';
        else{
            $sql = $base . 'VALUES ';
            $count = 1;
            each(function ($userId) use(&$sql, &$count, $groupId, $userIds) {
                $sql = $sql . PHP_EOL . "(" . (int)$groupId . ', ' . (int)$userId . ')' . ($count === count($userIds) ? ';' : ',');
                $count++;
            }, $userIds);
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::EXECUTE_MTHD,
            []
        );
    }

    /**
     * @param int $groupId
     * @param array $userIds
     * @return bool|\Exception|mixed
     */
    public function removeUserFromChatGroup(int $groupId, array $userIds)
    {
        $result = true;
        each(function ($userId) use($groupId, &$result) {
            if(($result = $this->buildAndExecuteFromSql(
                    $this->getEntityManager(),
                    $this->deleteGroupUsersSqlBase,
                    self::EXECUTE_MTHD,
                    [$userId, $groupId]
            )) instanceof \Exception){
                return $result;
            }
        }, $userIds);
        return $result;
    }

    /**
     * @param array $params
     * @return \Exception|string
     */
    public function insertNewChatGroupReturnId(array $params)
    {
        unset($params[self::GROUP_ID_KEY]);
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertIntoChatGroupSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
        if ($result instanceof \Exception)
            return $result;
        return $this->fetchGroupIdByGroupUuid($params[self::GROUP_UUID_KEY]);

    }

    /**
     * @param int $groupId
     * @param string $sqlName
     * @return \Exception|mixed
     * @throws \App\Repository\RepositoryException
     */
    public function fetchGroupDataByGroupId(int $groupId, string $sqlName)
    {
        if (!array_key_exists($sqlName, self::FETCH_CHAT_GROUP_DATA_BY_GROUP_ID_SQL))
            throw $this->getRepoException()::generalIssueError("Property $sqlName does not exist");
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            self::FETCH_CHAT_GROUP_DATA_BY_GROUP_ID_SQL[$sqlName][self::SQL_KEY],
            self::FETCH_CHAT_GROUP_DATA_BY_GROUP_ID_SQL[$sqlName][self::COL_METHOD_KEY],
            [$groupId]
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

    /**
     * @param int $groupId
     * @return array|\Exception
     */
    public function fetchGroupMemberIdsByGroupId(int $groupId)
    {
        $sql = 'SELECT market_user_id AS id FROM chat_group_market_users WHERE group_chat_id = ?';
        $result = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $sql,
            self::FETCH_ALL_ASSO_MTHD,
            [$groupId]
        );
        if ($result instanceof \Exception)
            return $result;
        return $this->flattenResultArrayByKey($result, self::GROUP_ID_KEY);

    }

    /**
     * @param string $uuid
     * @param string $field
     * @param $value
     * @return \Exception|mixed
     * @throws \App\Repository\RepositoryException
     */
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

    /**
     * @param int $id
     * @param string $field
     * @param $value
     * @return \Exception|mixed
     * @throws \App\Repository\RepositoryException
     */
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
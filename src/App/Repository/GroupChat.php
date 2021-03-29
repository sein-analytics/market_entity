<?php


namespace App\Repository;

use App\Repository\Chat\ChatAbstract;
use App\Repository\RepositoryException;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupChat extends ChatAbstract
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
            array_push($userIds, $userIds);
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

    public function insertNewUserGroupByUserId(array $params, int $user)
    {
    }

    /**
     * @param string $uuid
     * @return \Exception|mixed
     */
    public function fetchGroupIdByGroupUuid(string $uuid)
    {
        if (($sql = $this->attemptSqlBuild(self::UUID_COND, self::QUERY_JUST_ID))
            instanceof \Exception
        )
            return $sql;
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(), $sql, self::FETCH_ONE_MTHD, [$uuid]);
    }

    /**
     * @param int $user
     * @param string $option
     * @return \Exception|mixed
     */
    public function fetchGroupDetailByUserId(int $user, string $option=self::QUERY_JUST_ID)
    {
        if (($sql = $this->attemptSqlBuild(self::USER_ID_COND, $option))
            instanceof \Exception
        )
            return $sql;
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(), $sql,
            ($option === self::QUERY_JUST_ID ? self::FETCH_ONE_MTHD : self::FETCH_ASSO_MTHD),[$user]);
    }

    /**
     * @param string $target
     * @param string $conditional
     * @return \Exception|string
     */
    private function attemptSqlBuild(string $target, string $conditional)
    {
        try {
            return $this->buildSelectFromSql($target, $conditional);
        } catch (\Exception $exception){
            return $exception;
        }
    }

    /**
     * @param string $target
     * @param string $conditional
     * @return string
     * @throws \App\Repository\RepositoryException
     */
    protected function buildSelectFromSql(string $target, string $conditional)
    {
        if ($target !== self::QUERY_ALL && $target !== self::QUERY_JUST_ID)
            throw $this->getRepoException()::generalIssueError($this->unrecognizableTargetMsg(
                $target, 'buildSelectFromSql' ,get_class($this))
            );
        if ($conditional !== self::UUID_COND && $conditional !== self::USER_ID_COND)
            throw $this->getRepoException()::generalIssueError($this->unrecognizableConditionMsg(
                $conditional, 'buildSelectFromSql', get_class($this))
            );
        return "SELECT $target FROM ChatGroup WHERE $conditional = ?";
    }
}
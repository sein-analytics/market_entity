<?php


namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityRepository;

class ChatTracker extends EntityRepository
    implements DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait;

    const TRACKER_EXISTS = 'A tracker id exists for the uuid provided';

    protected $insertIntoTrackerSql = "insert into ChatTracker (`id`, `uuid`) value (NULL, ?)";

    protected $selectFromTrackerSql = "SELECT id FROM ChatTracker WHERE uuid = ?";

    public function addNewChatTracker(string $uuid)
    {
        if (($result = $this->buildAndExecuteSql(
            $this->selectFromTrackerSql, self::FETCH_ONE_MTHD, [$uuid])) instanceof \Exception)
            return $result;
        if (!$result){
            if (($result = $this->buildAndExecuteSql(
                $this->insertIntoTrackerSql, self::EXECUTE_MTHD, [$uuid])) instanceof \Exception)
                return $result;
            return $this->buildAndExecuteSql(
                $this->selectFromTrackerSql, self::FETCH_ONE_MTHD, [$uuid]);
        }
        return $result;
    }

    /**
     * @param string $sql
     * @param string $fetchMethod
     * @param array $orderedParams
     * @return mixed|\Exception
     */
    protected function buildAndExecuteSql(string $sql, string $fetchMethod, array $orderedParams=[])
    {
        if (($stmt = $this->buildStmtFromSql(
            $this->getEntityManager(), $sql, $orderedParams
        )) instanceof \Exception){
            return $stmt;
        }
        return $this->executeStatementFetchMethod($stmt, $fetchMethod);
    }
}
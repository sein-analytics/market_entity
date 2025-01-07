<?php


namespace App\Repository;


use App\Repository\Chat\ChatAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityRepository;
use Illuminate\Support\Str;

class ChatTracker extends ChatAbstract
{
    use FetchMapperTrait, FetchingTrait;

    const TRACKER_EXISTS = 'A tracker id exists for the uuid provided';

    protected $insertIntoTrackerSql = "insert into ChatTracker (`id`, `uuid`) value (NULL, ?)";

    protected $selectIdFromTrackerSql = "SELECT id FROM ChatTracker WHERE uuid = ?";

    /**
     * @return \Exception|mixed
     */
    public function addNewChatTrackerForUuid()
    {
        // if (($valid = $this->executeUuidValidation(
        //     $uuid, get_class($this), 'addNewChatTrackerForUuid')) instanceof \Exception)
        //     return $valid;
        $em = $this->getEntityManager();
        $trackerUuid = Str::uuid()->getHex()->toString();
        if (($result = $this->buildAndExecuteFromSql(
                $em, $this->insertIntoTrackerSql, self::EXECUTE_MTHD, [$trackerUuid])) instanceof \Exception)
            return $result;
        return $this->buildAndExecuteFromSql(
            $em, $this->selectIdFromTrackerSql, self::FETCH_ONE_MTHD, [$trackerUuid]);
    }

}
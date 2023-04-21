<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 1/18/18
 * Time: 2:04 PM
 */

namespace App\Repository;


use App\Repository\Message\MessageAbstract;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use function Lambdish\phunctional\{each};

class Message extends MessageAbstract
{
    use FetchingTrait, FetchMapperTrait;

    private string $insertMessageSql = "INSERT INTO Message VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateMessageSql = "UPDATE Message SET message=? WHERE id=?";

    private array $tableProps = [
        self::MSG_QRY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY => null],
        self::MSG_QRY_USER_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::MSG_QRY_DEAL_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY => null],
        self::MSG_QRY_LOAN_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY => null],
        self::MSG_QRY_TYPE_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::MSG_INFORMATION_TYPE],
        self::QRY_ORIGINATOR_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::USER_ORIGINATOR],
        self::MSG_QRY_STATUS_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>self::MSG_UNREAD_STATUS],
        self::MSG_QRY_PRIORITY_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>self::PRIORITY_NORMAL],
        self::MSG_QRY_ACTION_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>self::ACTION_NONE],
        self::MSG_QRY_ISSUE_ID_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::MSG_QRY_DATE_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::MSG_QRY_SUBJECT_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::MSG_QRY_MSG_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => false, self::TBL_PROP_DEFAULT_KEY=>self::TBL_PROP_NONE_DEFAULT],
        self::MSG_QRY_SEND_STATUS_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>null],
        self::MSG_QRY_RECIPIENT_IDS_KEY => [self::TBL_PROP_ENTITY_KEY => null,
            self::TBL_PROP_NULLABLE_KEY => true, self::TBL_PROP_DEFAULT_KEY=>null],
    ];

    public function insertNewMessage(array $params):mixed
    {
        if (array_key_exists(self::MSG_QRY_ID_KEY, $params))
            unset($params[self::MSG_QRY_ID_KEY]);
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->insertMessageSql,
            self::EXECUTE_MTHD,
            array_values($params)
        );
    }

    public function updateMessageByMessageId (int $msgId, string $message):mixed
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->updateMessageSql,
            self::EXECUTE_MTHD,
            [$message, $msgId]
        );
    }

    public function fetchMessageIdsFromUserMessage(int $userId)
    {
        $sql = "SELECT message_id FROM market_user_message WHERE market_user_id = ?";
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $userId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $this->flattenResultArrayByKey($results, 'message_id');
    }

    /**
     * @param int $msgId
     * @param int $userId
     * @return bool|string
     */
    public function deleteFromMarketUserMessage(int $msgId, int $userId)
    {
        $sql = "DELETE FROM market_user_message WHERE message_id = ? AND  market_user_id = ?";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->bindValue(1, $msgId);
            $stmt->bindValue(2, $userId);
        }catch (DBALException $e){
            return $e->getMessage();
        }
        $stmt->execute();
        return true;
    }

    public function returnBaseInsertArray():array
    {
        $base = [];
        each(function ($props, $key) use(&$base) {
            if ($props[self::TBL_PROP_DEFAULT_KEY] === self::TBL_PROP_NONE_DEFAULT)
                $base[$key] = null;
            else
                $base[$key] = $props[self::TBL_PROP_DEFAULT_KEY];
        }, $this->tableProps);
        return $base;
    }

    public function returnTablePropsArray ():array { return $this->tableProps; }
}
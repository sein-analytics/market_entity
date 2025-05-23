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

use function Lambdish\phunctional\{each};

class Message extends MessageAbstract
{
    use FetchingTrait, FetchMapperTrait;

    private string $insertMessageSql = "INSERT INTO Message VALUE (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    private string $updateMessageSql = "UPDATE Message SET message=? WHERE id=?";
    
    private string $multipleInsertsMessages = "INSERT INTO Message " . 
        "(`user_id`, `deal_id`, `loan_id`, `type_id`, `originator_id`, `status_id`, `priority_id`, 
        `action_id`, `issue_id`, `date`, `subject`, `message`, `send_status`, `msg_recipient_ids`)" . 
        " VALUES";

    private string $fetchMessageIdsFromUserMessageSql = "SELECT message_id FROM market_user_message WHERE market_user_id = ?";

    private string $deleteFromMarketUserMessageSql = "DELETE FROM market_user_message WHERE message_id = ? AND  market_user_id = ?";

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
        $results = $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchMessageIdsFromUserMessageSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$userId]
        );

        $results = $this->flattenResultArrayByKey($results, 'message_id');

        return $results;
    }

    /**
     * @param int $msgId
     * @param int $userId
     * @return bool|string
     */
    public function deleteFromMarketUserMessage(int $msgId, int $userId)
    {
        $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->deleteFromMarketUserMessageSql,
            self::EXECUTE_MTHD,
            [$msgId, $userId]
        );
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

    public function addMultiMessageInputs(array $messages)
    {
        $base = $this->multipleInsertsMessages;
        $insertCount = 0;
        $nullValue = "NULL";
        foreach($messages as $message) {
            $insertCount++;
            $base = $base . PHP_EOL .
            '(' .
                $message[self::MSG_QRY_USER_ID_KEY] . ',' .
                $message[self::MSG_QRY_DEAL_ID_KEY] . ',' .
                (is_null($message[self::MSG_QRY_LOAN_ID_KEY]) ? "$nullValue" : $message[self::MSG_QRY_LOAN_ID_KEY]) . ',' .
                $message[self::MSG_QRY_TYPE_ID_KEY] . ',' .
                $message[self::QRY_ORIGINATOR_ID_KEY] . ',' .
                $message[self::MSG_QRY_STATUS_ID_KEY] . ',' .
                $message[self::MSG_QRY_PRIORITY_ID_KEY] . ',' .
                $message[self::MSG_QRY_ACTION_ID_KEY] . ',' .
                "$nullValue" . ',' .
                "'" . $message[self::MSG_QRY_DATE_KEY] . "'" . ',' .
                "'" . $message[self::MSG_QRY_SUBJECT_KEY] . "'" . ',' .
                "'" . $message[self::MSG_QRY_MSG_KEY] . "'" . ',' .
                "$nullValue" . ',' .
                "'" . $message[self::MSG_QRY_RECIPIENT_IDS_KEY] . "'" .
                ')' . ($insertCount == count($messages) ? ';' : ','); 
        }
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $base,
            self::EXECUTE_MTHD,
            []
        );
    }
}
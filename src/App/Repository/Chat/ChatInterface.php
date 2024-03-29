<?php


namespace App\Repository\Chat;


interface ChatInterface
{
    const QRY_ID_KEY = 'id';

    const QRY_USER_ID_KEY = 'user_id';

    const QRY_RECIPIENT_ID_KEY = 'recipient_id';

    const QRY_GROUP_ID_KEY = 'group_id';

    const CHAT_MSG_MSG_KEY = 'message';

    const QRY_MSG_DATE_KEY = 'message_date';

    const QRY_MSG_FILES_KEY = 'attachments';

    const QRY_TRACKER_ID_KEY = 'tracker_id';

    const QRY_CONTACT_ID_KEY = 'contact_id';

    const QRY_STATUS_ID_KEY = 'status_id';

    const QRY_IS_GROUP_KEY = 'is_group';

    const QRY_KEY_IND = 'key';

    const QRY_VAR_DEFAULT = 'default';

    const DEFAULT_BLOB = '<p></p>';

    const QRY_VAR_MTHD_KEY = 'method';

    const BASE_STATUS = 1;

    const GLACIER_STATUS = 2;

    const DELETE_STATUS = 3;

    const QRY_ID_VAR = [
        self::QRY_VAR_DEFAULT => null,
        self::QRY_KEY_IND => self::QRY_ID_KEY
    ];

    const QRY_USER_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_USER_ID_KEY
    ];

    const QRY_RECIPIENT_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_RECIPIENT_ID_KEY,
        self::QRY_VAR_DEFAULT => null,
    ];

    const QRY_GROUP_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_GROUP_ID_KEY,
        self::QRY_VAR_DEFAULT => null,
    ];

    const QRY_MESSAGE_VAR = [
        self::QRY_KEY_IND => self::CHAT_MSG_MSG_KEY,
        self::QRY_VAR_DEFAULT => self::DEFAULT_BLOB
    ];

    const QRY_MSG_DATE_VAR = [
        self::QRY_KEY_IND => self::QRY_MSG_DATE_KEY,
        self::QRY_VAR_MTHD_KEY => 'date'
    ];

    const QRY_MSG_FILES_VAR = [
        self::QRY_KEY_IND => self::QRY_MSG_FILES_KEY,
        self::QRY_VAR_DEFAULT => null
    ];

    const QRY_TRACKER_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_TRACKER_ID_KEY
    ];

    const QRY_CONTACT_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_CONTACT_ID_KEY,
        self::QRY_VAR_DEFAULT => null
    ];

    const QRY_STATUS_ID_VAR = [
        self::QRY_KEY_IND => self::QRY_STATUS_ID_KEY,
        self::QRY_VAR_DEFAULT => 1
    ];

    const QRY_IS_GROUP_VAR = [
        self::QRY_KEY_IND => self::QRY_IS_GROUP_KEY,
        self::QRY_VAR_DEFAULT => 0
    ];

    const CHAT_QRY_MAPPER = [
        self::QRY_ID_KEY => self::QRY_ID_VAR,
        self::QRY_USER_ID_KEY => self::QRY_USER_ID_VAR,
        self::QRY_RECIPIENT_ID_KEY => self::QRY_RECIPIENT_ID_VAR,
        self::QRY_GROUP_ID_KEY => self::QRY_GROUP_ID_VAR,
        self::CHAT_MSG_MSG_KEY => self::QRY_MESSAGE_VAR,
        self::QRY_MSG_DATE_KEY => self::QRY_MSG_DATE_VAR,
        self::QRY_MSG_FILES_KEY => self::QRY_MSG_FILES_VAR,
        self::QRY_TRACKER_ID_KEY => self::QRY_TRACKER_ID_VAR,
        self::QRY_CONTACT_ID_KEY => self::QRY_CONTACT_ID_VAR,
        self::QRY_STATUS_ID_KEY => self::QRY_STATUS_ID_VAR,
        self::QRY_IS_GROUP_KEY => self::QRY_IS_GROUP_VAR
    ];

    const QRY_BASE_INSERT_ARR = [
        self::QRY_ID_KEY => null,
        self::QRY_USER_ID_KEY => null,
        self::QRY_RECIPIENT_ID_KEY => null,
        self::QRY_GROUP_ID_KEY => null,
        self::CHAT_MSG_MSG_KEY => null,
        self::QRY_MSG_DATE_KEY => null,
        self::QRY_MSG_FILES_KEY => null,
        self::QRY_TRACKER_ID_KEY => null,
        self::QRY_CONTACT_ID_KEY => null,
        self::QRY_STATUS_ID_KEY => null,
        self::QRY_IS_GROUP_KEY => null
    ];

    const TRACKER_BY_CONTACT_AND_USER_ID = 'SELECT DISTINCT tracker_id AS id FROM Chat WHERE contact_id = ? ' .
    'AND user_id = ? OR contact_id = ? AND recipient_id = ?';

    const CHAT_MESSAGE_MONGO_COLLECTION = 'message';

    const CHAT_MESSAGE_MONGO_ID_KEY = '_id';
    
    const CHAT_MESSAGE_MONGO_CREATED_KEY = 'created';
    
    const CHAT_MESSAGE_MONGO_CHAT_KEY = 'chatId';
    
    const CHAT_MESSAGE_MONGO_TEXT_KEY = 'text';
    
    const CHAT_MESSAGE_MONGO_ATTACHMENTS_KEY = 'attachments';
    
    const CHAT_MESSAGE_MONGO_AUTHOR_KEY = 'authorId';

    const MONGO_MATCH_KEY = '$match';
    const MONGO_IN_KEY = '$in';
    const MONGO_GROUP_KEY = '$group';
    const MONGO_LAST_KEY = '$last';
    const MONGO_PUSH_KEY = '$push';
    const MONGO_TO_STRING_KEY = '$toString';
    const MONGO_REPLACE_ROOT_KEY = '$replaceRoot';
    const MONGO_NEW_ROOT_KEY = '$newRoot';
    const MONGO_ARRAY_TO_OBJECT_KEY = '$arrayToObject';
    const MONGO_LAST_MESSAGE_RESULT_KEY = 'lastMessage';
    const MONGO_RESULT_KEY = 'result';
}
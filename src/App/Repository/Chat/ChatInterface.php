<?php


namespace App\Repository\Chat;


interface ChatInterface
{
    CONST QRY_ID_KEY = 'id';

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


}
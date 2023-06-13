<?php

namespace App\Repository\Message;

interface MessageInterface
{
    const MSG_QRY_ID_KEY = 'id';

    const MSG_QRY_USER_ID_KEY = 'user_id';

    const MSG_QRY_DEAL_ID_KEY = 'deal_id';

    const MSG_QRY_LOAN_ID_KEY = 'loan_id';

    const MSG_QRY_TYPE_ID_KEY = 'type_id';

    const QRY_ORIGINATOR_ID_KEY = 'originator_id';

    const MSG_QRY_STATUS_ID_KEY = 'status_id';

    const MSG_QRY_PRIORITY_ID_KEY = 'priority_id';

    const MSG_QRY_ACTION_ID_KEY = 'action_id';

    const MSG_QRY_ISSUE_ID_KEY = 'issue_id';

    const MSG_QRY_DATE_KEY = 'date';

    const MSG_QRY_SUBJECT_KEY = 'subject';

    const MSG_QRY_MSG_KEY = 'message';

    const MSG_QRY_SEND_STATUS_KEY = 'send_status';

    const MSG_QRY_RECIPIENT_IDS_KEY = 'msg_recipient_ids';

    const MSG_RESPONSE_TYPE = 2;

    const MSG_REQUEST_TYPE = 1;

    const MSG_INFORMATION_TYPE = 3;

    const SYSTEM_ORIGINATOR = 2;

    const ADMIN_ORIGINATOR = 1;

    const USER_ORIGINATOR = 3;

    const MSG_UNREAD_STATUS = 1;

    const MSG_READ_STATUS = 2;

    const PRIORITY_NORMAL = 1;

    const PRIORITY_IMPORTANT = 2;

    const ACTION_VIEW_DOC = 1;

    const ACTION_UPLOAD_DOC = 2;

    const ACTION_VIEW_BIDS = 3;

    const ACTION_NONE = 4;
}
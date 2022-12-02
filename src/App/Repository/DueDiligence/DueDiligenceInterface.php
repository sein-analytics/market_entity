<?php

namespace App\Repository\DueDiligence;

interface DueDiligenceInterface
{
    const DD_QRY_ID_KEY = 'id';

    const DD_QRY_USER_ID_KEY = 'user_id';

    const DD_QRY_DEAL_ID_KEY = 'deal_id';

    const DD_QRY_ROLE_ID_KEY = 'dd_role_id';

    const DD_QRY_STATUS_ID_KEY = 'dd_status_id';

    const DD_QRY_BID_ID_KEY = 'bid_id';

    const DD_QRY_PARENT_ID_KEY = 'parent_id';

    const LEADER_ROLE = 1;

    const MEMBER_ROLE = 2;

    const DD_OPEN_TEXT = "Open";

    const DD_OPEN_STATUS = 1;

    const DD_CLOSED_TEXT = "Closed";

    const DD_CLOSED_STATUS = 2;

    const DD_ACCEPTED_TEXT = "Accepted";

    const DD_ACCEPTED_STATUS = 3;

    const DD_REJECTED_TEXT = "Rejected";

    const DD_REJECTED_STATUS = 4;

    const FILE_DD_MANY_TO_MANY_TBL = 'deal_file_due_diligence';

    const MANY_TO_MANY_DD_ID_KEY = 'due_diligence_id';

    const MANY_TO_MANY_FILE_ID_KEY = 'deal_file_id';

    const DD_EXIST_IN_FILE_MANY_TO_MANY_QRY = "SELECT COUNT(due_diligence_id) FROM deal_file_due_diligence WHERE due_diligence_id = ?";

    const DD_EXIST_IN_FILE_MANY_TO_MANY_BY_FILE_QRY = "SELECT COUNT(due_diligence_id) FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    const FILE_EXIST_IN_FILE_MANY_TO_MANY_QRY = "SELECT COUNT(deal_file_id) FROM deal_file_due_diligence WHERE deal_file_id = ?";

    const FILE_EXIST_IN_FILE_MANY_TO_MANY_BY_DD_QRY = "SELECT COUNT(deal_file_id) FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    const ANNOTATION_API_KEY = "annotationItem";

    const DD_USER_API_KEY = "dueDiligenceUser";

    const DD_FILE_USER_KEY = "dueDiligenceFileUser";

    const API_BID_ID_KEY = "bidId";

    const API_DD_USER_ISSUER_ID_KEY = "ddUserIssuerId";

    const API_DD_USER_ID_KEY = "dueDilUser";

    const API_DEAL_ID_KEY = "dealId";

    const API_DUE_DIL_ID_KEY = "dueDilId";

    const API_DD_LN_STATUS_KEY = "dueDilLnStatus";

    const API_DD_FILE_ID_KEY = "fileId";

    const API_ISSUER_ID_KEY = "issuerId";

    const API_LOAN_ID_KEY = "loanId";

    const API_LOGGER_KEY = "logger";

    const API_FILES_KEY = "files";

    const API_LOAN_STATUS_ID_KEY = "loanStatusId";

    const API_LOGGER_ACTIONS_KEY = "actions";

    const API_LOGGER_ACTION_KEY = "action";

    const API_LOGGER_DATE_KEY = "date";

    const API_LOGGER_USER_ID_KEY = "userId";

    const API_LOGGER_ACTION_DATA_KEY = "actionData";

    const ASSIGN_FILE_ACTION = "assignFile";

    const CREATE_COMMENT_ACTION = "createComment";

    const ADD_REPLY_ACTION = "createComment";

    const UPDATE_COMMENT_ACTION = "updateComment";

    const UPDATE_LOAN_STATUS_ACTION = "updateLoanStatus";

    const LOGGER_ACTIONS_BASE = [
        self::API_LOGGER_DATE_KEY => '',
        self::API_LOGGER_USER_ID_KEY => '',
        self::API_LOGGER_ACTION_KEY => '',
        self::API_LOGGER_ACTION_DATA_KEY => ''
    ];

    const DD_STATUS_TO_IT = [
        self::DD_OPEN_TEXT => self::DD_OPEN_STATUS,
        self::DD_CLOSED_TEXT => self::DD_CLOSED_STATUS,
        self::DD_ACCEPTED_TEXT => self::DD_ACCEPTED_STATUS,
        self::DD_REJECTED_TEXT => self::DD_REJECTED_STATUS,
    ];

    const DD_USER_API_NEW_TEAM_MEMBER = [
        self::DD_QRY_ID_KEY => null,
        self::DD_QRY_USER_ID_KEY => self::API_LOGGER_USER_ID_KEY,
        self::DD_QRY_DEAL_ID_KEY => self::API_DEAL_ID_KEY,
        self::DD_QRY_ROLE_ID_KEY => self::MEMBER_ROLE,
        self::DD_QRY_STATUS_ID_KEY => self::API_DD_LN_STATUS_KEY,
        self::DD_QRY_BID_ID_KEY => null,
        self::DD_QRY_PARENT_ID_KEY => self::API_DUE_DIL_ID_KEY
    ];
}
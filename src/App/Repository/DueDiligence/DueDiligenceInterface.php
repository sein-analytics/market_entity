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

    const DD_QRY_DEAL_KEY = 'deal';

    const DD_QRY_USER_KEY = 'user';

    const LEADER_ROLE = 1;

    const MEMBER_ROLE = 2;

    const DD_OPEN_TEXT = "Open";

    const DD_ACCEPT_TEXT = "Accept";

    const DD_OPEN_STATUS = 1;

    const DD_CLOSED_TEXT = "Closed";

    const DD_CLOSED_STATUS = 2;

    const DD_ACCEPTED_TEXT = "Accepted";

    const DD_ACCEPTED_STATUS = 3;

    const DD_REJECTED_TEXT = "Rejected";

    const DD_REJECTED_STATUS = 4;

    const DD_ACCEPT_STATUS = 5;

    const FILE_DD_MANY_TO_MANY_TBL = 'deal_file_due_diligence';

    const MANY_TO_MANY_DD_ID_KEY = 'due_diligence_id';

    const MANY_TO_MANY_FILE_ID_KEY = 'deal_file_id';

    const DD_EXIST_IN_FILE_MANY_TO_MANY_QRY = "SELECT COUNT(due_diligence_id) FROM deal_file_due_diligence WHERE due_diligence_id = ?";

    const DD_EXIST_IN_FILE_MANY_TO_MANY_BY_FILE_QRY = "SELECT COUNT(due_diligence_id) FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    const FILE_EXIST_IN_FILE_MANY_TO_MANY_QRY = "SELECT COUNT(deal_file_id) FROM deal_file_due_diligence WHERE deal_file_id = ?";

    const FILE_EXIST_IN_FILE_MANY_TO_MANY_BY_DD_QRY = "SELECT COUNT(deal_file_id) FROM deal_file_due_diligence WHERE due_diligence_id = ? AND deal_file_id = ?";

    const ANNOTATION_API_KEY = "annotationItem";

    const API_ANNOTATION_ID_KEY = "annotationId";

    const API_ANNOTATION_NOTE_KEY = "note";

    const API_ANNOT_NOTIFY_SELLER_KEY = "notifySeller";

    const API_ANNOT_NOTIFY_TEAM_KEY = "notifyTeam";

    const API_ANNOT_IMPORTANT_KEY = "important";

    const API_ANNOT_IS_ISSUE_KEY = "isIssue";

    const DD_USER_API_KEY = "dueDiligenceUser";

    const DD_FILE_USER_KEY = "dueDiligenceFileUser";

    const API_BID_ID_KEY = "bidId";

    const API_DD_USER_ISSUER_ID_KEY = "ddUserIssuerId";

    const API_DD_USER_ID_KEY = "dueDilUser";

    const API_DEAL_ID_KEY = "dealId";

    const API_DUE_DIL_ID_KEY = "dueDilId";

    const API_DD_LN_STATUS_KEY = "dueDilLnStatus";

    const API_DD_FILE_ID_KEY = "fileId";

    const API_USER_DD_ROLE_KEY = "userDdRole";

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

    const API_DD_USER_TEAM_KEY = "dueDiligenceTeam";

    const API_TEAM_ROLE_ID_KEY = "roleId";

    const API_TEAM_EMAIL_KEY = "email";

    const API_TEAM_MEMBER_NAME_KEY = "teamMemberName";

    const API_DD_PARENT_KEY = "ddParent";

    const API_DD_ISSUE_ID_KEY = "issueId";

    const API_ANNOT_ISSUE_COMMENT_ACTION_KEY = "annotCommentIssueAction";

    const API_ADD_NEW_ANNOTATION_ACTION = "addAnnotation";

    const API_CREATE_NEW_ISSUE_ACTION = "createIssue";

    const API_CLOSE_ISSUE_ACTION = "closeIssue";

    const API_UPDATE_ANNOT_TEXT_ACTION = "updateAnnotNote";

    const API_ADD_COMMENT_ACTION = "addNewComment";

    const API_UPDATE_COMMENT_ACTION = "updateComment";

    const API_DELETE_ANNOT_ACTION = "deleteAnnot";

    const API_DELETE_COMMENT_ACTION = "deleteComment";

    const API_FILE_UPDATE_FILE_KEY = "updateFileData";

    const API_FILE_UPDATE_LOAN_KEY = "updateFileLoanData";

    const API_RESIZE_ANNOT_ACTION = "resizeAnnot";

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
        self::DD_QRY_STATUS_ID_KEY => self::DD_OPEN_STATUS,
        self::DD_QRY_BID_ID_KEY => null,
        self::DD_QRY_PARENT_ID_KEY => self::API_DUE_DIL_ID_KEY
    ];

    const DUE_DIF_FILE_ANNOT_COMMENT_ISSUE_ACTIONS = [
        self::API_ADD_NEW_ANNOTATION_ACTION,
        self::API_CREATE_NEW_ISSUE_ACTION,
        self::API_CLOSE_ISSUE_ACTION,
        self::API_UPDATE_ANNOT_TEXT_ACTION,
        self::API_ADD_COMMENT_ACTION,
        self::API_UPDATE_COMMENT_ACTION,
        self::API_DELETE_ANNOT_ACTION,
        self::API_DELETE_COMMENT_ACTION,
        self::API_RESIZE_ANNOT_ACTION
    ];

    const API_REQUESTER_ID_KEY = "requesterId";

    const API_FILES_IDS_KEY = "filesIds";

    const API_BIDDER_ID = "bidderId";

    const API_LOAN_NUMBER_KEY = "loanNumber";

    const GRANT_ACCESS_SUBJECT_TEXT = "Request for documents";

    const BID_HISTORY_REQUESTS_KEY = "requests";

    const BID_HISTORY_USERS_KEY = "users";

    const BID_HISTORY_MSG_KEY = "message";

    const BID_HISTORY_LOANS_KEY = "loans";

    const BID_HISTORY_LOAN_STATUS_KEY = "status";

    const BID_HISTORY_DOC_REQ_RESOLVED_TEXT = "Resolved";

    const BID_HISTORY_LOANS_RESOLVED_KEY = "loansResolved";

    const BID_HISTORY_REQUEST_ID_KEY = "requestId";

    const DD_FILE_ACTION_RESPONSE_ACCEPTED_KEY = "accepted";

    const DD_COMMENTS_ISSUES_COUNT_KEY = "issuesCount";

    const DD_ACTIONS_ACCEPT_COUNT_KEY = "acceptActionsCount";

    const DD_COMMENTS_FILE_ISSUES_COUNT_KEY = "fileIssuesCount";

    const DD_ACTIONS_FILE_ACCEPT_COUNT_KEY = "fileAcceptCount";

    const DD_REQUEST_LOAN_DOCS_SUBJECT_KEY = 'subject';

    const DD_REQUEST_LOAN_DOCS_VALIDATIONS = [
        self::DD_REQUEST_LOAN_DOCS_SUBJECT_KEY => 'required|string',
        self::BID_HISTORY_LOANS_KEY => 'required|array',
        self::BID_HISTORY_LOANS_KEY . '.*.' .
            self::API_LOAN_NUMBER_KEY => 'required|string',
        self::BID_HISTORY_LOANS_KEY . '.*.' .
            self::API_LOAN_ID_KEY => 'required|integer',
        self::API_DEAL_ID_KEY => 'required|integer',
        self::API_BID_ID_KEY => 'required|integer'
    ];

}
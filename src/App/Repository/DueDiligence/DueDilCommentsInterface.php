<?php

namespace App\Repository\DueDiligence;

use App\Repository\MongoKeysInterface;

interface DueDilCommentsInterface extends MongoKeysInterface
{

    const DD_COMMENTS_COLLECTION_NAME = "comments";

    const DD_COMMENT_REQUEST_ID = "id";

    const DD_COMMENT_LOAN_ID_KEY = "loanId";

    const DD_COMMENT_FILE_ID = "fileId";

    const DD_COMMENT_PARENT_KEY = "parent";

    const DD_COMMENT_LOAN_SUBJECT_KEY = "subject";

    const DD_COMMENT_LOAN_NOTE_KEY = "note";

    const DD_COMMENT_AUTHOR_ID_KEY = "authorId";

    const DD_COMMENT_AUTHOR_NAME_KEY = "authorName";

    const DD_COMMENT_DATE_KEY = "date";

    const DD_COMMENT_IS_ISSUE_KEY = "isIssue";

    const DD_COMMENT_IS_IMPORTANT_KEY = "isImportant";

    const DD_COMMENT_NOTIFY_SELLER_KEY = "notifySeller";

    const DD_COMMENT_NOTIFY_TEAM_KEY = "notifyTeam";

    const DD_COMMENT_RESOLVED_ISSUE_KEY = "resolvedIssue";

    const DD_COMMENT_ANNOT_PROPERTIES_KEY = "annotationProperties";

    const DD_COMMENTS_REPLIES_KEY = "replies";

    const DD_COMMENTS_REPLY_KEY = "reply";

    const VALIDATOR_NULLABLE_TYPE = "nullable";

    const VALIDATOR_BOOLEAN_TYPE = "boolean";

    const VALIDATOR_STRING_TYPE = "string";

    const VALIDATOR_DATE_TYPE = "date";

    const DD_COMMENT_REQ_PAGE_NUMBER_KEY = "pageNumber";

    const DD_COMMENT_REQ_PAGE_SIZE_KEY = "pageSize";

    const DD_COMMENT_REQ_ERROR_MESSAGE_KEY = "message";

    const DD_COMMENT_INVALID_ID_TEXT = "Invalid id sent in request";

    const DD_COMMENT_INVALID_KEYS_TEXT = "Invalid properties sent in request";

    const DD_COMMENT_EVENT_CREATE_ACTION = "Create";

    const DD_COMMENT_EVENT_DELETE_ACTION = "Delete";

    const DD_COMMENT_EVENT_UPDATE_ACTION = "Update";

    const DD_COMMENTS_VALID_KEYS = [
        self::DD_COMMENT_LOAN_ID_KEY,
        self::DD_COMMENT_FILE_ID,
        self::DD_COMMENT_PARENT_KEY,
        self::DD_COMMENT_LOAN_SUBJECT_KEY,
        self::DD_COMMENT_LOAN_NOTE_KEY,
        self::DD_COMMENT_AUTHOR_ID_KEY,
        self::DD_COMMENT_AUTHOR_NAME_KEY,
        self::DD_COMMENT_DATE_KEY,
        self::DD_COMMENT_IS_ISSUE_KEY,
        self::DD_COMMENT_IS_IMPORTANT_KEY,
        self::DD_COMMENT_NOTIFY_SELLER_KEY,
        self::DD_COMMENT_NOTIFY_TEAM_KEY,
        self::DD_COMMENT_RESOLVED_ISSUE_KEY,
        self::DD_COMMENT_ANNOT_PROPERTIES_KEY
    ];

    const DD_COMMENTS_ANNOT_PROPS_PDF_ANNOT_KEY = "pdfAnnotation";

    const DD_COMMENTS_ANNOT_PROPS_SHAPE_ANNOT_KEY = "shapeAnnotation";

    const DD_COMMENTS_ANNOT_PROPS_PAGE_KEY = "page";

    const DD_COMMENTS_ANNOT_PROPS_RECT_KEY = "rect";

    const DD_COMMENTS_ANNOT_RECT_HELPER_KEY = "annotRect";

    const DD_COMMENTS_RESPONSE_DATA_KEY = "data";

    const DD_COMMENTS_RESPONSE_ACTION_KEY = "action";

    const DD_COMMENTS_RESPONSE_TOTAL_COUNT_KEY = "totalCount";

    const DD_COMMENTS_RESPONSE_TOTAL_PAGES_KEY = "totalPages";

    const DD_COMMENTS_RESPONSE_COUNT_KEY = "count";

    const DD_COMMENTS_REQ_GT_KEY = "gt";

    const DD_COMMENTS_REQ_LT_KEY = "lt";
    
    const DD_COMMENTS_REQ_GTE_KEY = "gte";

    const DD_COMMENTS_ANNOT_PROPS_MONGO_PROJECT = [
        self::MONGO_PROJECT_KEY => [
            self::DD_COMMENT_MONGO_ID_KEY => 0,
            self::DD_COMMENTS_ANNOT_PROPS_PDF_ANNOT_KEY =>
            '$' . self::DD_COMMENT_ANNOT_PROPERTIES_KEY .
                '.' . self::DD_COMMENTS_ANNOT_PROPS_PDF_ANNOT_KEY
        ]
    ];

    const DD_COMMENTS_ID_AGGREGATION_ADD_FIELDS = [
        self::MONGO_ADD_FIELDS_KEY => [
            self::DD_COMMENT_MONGO_ID_KEY => [
                self::MONGO_TO_STRING_FUNCTION =>
                self::MONGO_UNIQUE_ID_KEY
            ],
            self::DD_COMMENTS_REPLIES_KEY => [
                self::MONGO_MAP_KEY => [
                    self::MONGO_MAP_INPUT_KEY =>
                    '$' . self::DD_COMMENTS_REPLIES_KEY,
                    self::MONGO_LOOKUP_AS_KEY =>
                    self::DD_COMMENTS_REPLY_KEY,
                    self::MONGO_MAP_IN_KEY => [
                        self::MONGO_MERGE_OBJECTS_KEY => [
                            '$$' . self::DD_COMMENTS_REPLY_KEY,
                            [
                                self::DD_COMMENT_MONGO_ID_KEY => [
                                    self::MONGO_TO_STRING_FUNCTION =>
                                    '$$' . self::DD_COMMENTS_REPLY_KEY .
                                        '.' . self::DD_COMMENT_MONGO_ID_KEY
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    const DD_COMMENTS_RESPONSE_AGGREGATION_PROJECT = [
        self::MONGO_PROJECT_KEY => [
            self::DD_COMMENT_MONGO_ID_KEY => 1,
            self::DD_COMMENT_LOAN_ID_KEY => 1,
            self::DD_COMMENT_FILE_ID => 1,
            self::DD_COMMENT_PARENT_KEY => 1,
            self::DD_COMMENTS_REPLIES_KEY => 1,
            self::DD_COMMENT_DATE_KEY => 1,
            self::DD_COMMENT_AUTHOR_ID_KEY => 1,
            self::DD_COMMENT_AUTHOR_NAME_KEY => 1,
            self::DD_COMMENT_LOAN_SUBJECT_KEY => 1,
            self::DD_COMMENT_LOAN_NOTE_KEY => 1,
            self::DD_COMMENT_IS_ISSUE_KEY => 1,
            self::DD_COMMENT_IS_IMPORTANT_KEY => 1,
            self::DD_COMMENT_NOTIFY_SELLER_KEY => 1,
            self::DD_COMMENT_NOTIFY_TEAM_KEY => 1,
            self::DD_COMMENT_RESOLVED_ISSUE_KEY => 1,
            self::DD_COMMENT_ANNOT_PROPERTIES_KEY => 1
        ]
    ];
}
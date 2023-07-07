<?php

namespace App\Repository\DueDiligence;

interface DueDilCommentsInterface
{

    const DD_COMMENTS_COLLECTION_NAME = "comments";

    const DD_COMMENT_MONGO_ID_KEY = "_id";

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

    const VALIDATOR_NULLABLE_TYPE = "nullable";

    const VALIDATOR_BOOLEAN_TYPE = "boolean";

    const VALIDATOR_STRING_TYPE = "string";

    const VALIDATOR_DATE_TYPE = "date";

    const DD_COMMENT_REQ_ERROR_MESSAGE_KEY = "message";
    
    const DD_COMMENT_INVALID_ID_TEXT = "Invalid id sent in request";

    const DD_COMMENT_INVALID_KEYS_TEXT = "Invalid properties sent in request";

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

    const MONGO_SET_KEY = '$set';

    const MONGO_MATCH_KEY = '$match';

    const MONGO_ADD_FIELDS_KEY = '$addFields';

    const MONGO_LOOKUP_KEY = '$lookup';

    const MONGO_UNWIND_KEY = '$unwind';

    const MONGO_SORT_KEY = '$sort';

    const MONGO_LOOKUP_FROM_KEY = "from";

    const MONGO_LOOKUP_LOCAL_FIELD_KEY = "localField";

    const MONGO_LOOKUP_FOREIGN_FIELD_KEY = "foreignField";

    const MONGO_LOOKUP_AS_KEY = "as";

    const MONGO_TO_STRING_FUNCTION = '$toString';

    const MONGO_UNIQUE_ID_KEY = '$_id';

    const MONGO_BASE_UPDATE_STRUCTURE = [
        self::MONGO_SET_KEY => []
    ];
}
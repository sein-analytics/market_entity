<?php

namespace App\Repository\DueDiligence;

interface DueDilCommentsInterface
{
    const DD_COMMENTS_COLLECTION_NAME = "comments";

    const DD_COMMENT_MONGO_ID_KEY = "_id";

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

    const VALIDATOR_NULLABLE_TYPE = "nullable";

    const VALIDATOR_BOOLEAN_TYPE = "boolean";

    const VALIDATOR_STRING_TYPE = "string";

    const VALIDATOR_DATE_TYPE = "date";
}
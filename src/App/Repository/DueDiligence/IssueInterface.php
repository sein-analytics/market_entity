<?php

namespace App\Repository\DueDiligence;

interface IssueInterface
{
    const ISS_QRY_ID_KEY = 'id';

    const QRY_DD_ID_KEY = 'due_diligence_id';

    const QRY_STATUS_ID_KEY = 'status_id';

    const QRY_FILE_ID_KEY = 'file_id';

    const QRY_PRIORITY_ID_KEY = 'priority_id';

    const QRY_LOAN_ID_KEY = 'loan_id';

    const QRY_ISS_TEXT = 'issue';

    const QRY_NOTIFY_SELLER_KEY = 'notify_seller';

    const QRY_NOTIFY_TEAM_KEY = 'notify_team';

    const QRY_OPEN_DATE_KEY = 'open_date';

    const QRY_CLOSE_DATE_KEY = 'closed_date';

    const QRY_ANNO_ID_KEY = 'annotation_id';

    const ISSUE_OPEN_STATUS = 1;

    const ISSUE_CLOSED_STATUS = 2;

    const ISSUE_ACCEPTED_STATUS = 4;

    const ISSUE_REJECTED_STATUS = 4;

    const NORMAL_ISSUE = 1;

    const IMPORTANT_ISSUE = 2;

}
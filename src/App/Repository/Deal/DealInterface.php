<?php

namespace App\Repository\Deal;

interface DealInterface
{
 
    const DEAL_QRY_DEAL_ID_KEY = 'deal_id';

    const DEAL_QRY_BUYER_ID_KEY = 'buyer_id';

    const DEAL_QRY_USER_ID_KEY = 'user_id';

    const DEAL_QRY_STATUS_KEY = 'status_id';

    const DEAL_QRY_REQUIRES_NDA_KEY = 'requires_nda';

    const DEAL_ALIVE_STATUS = 1;

    const DEAL_WAITING_CONFIRM_STATUS = 2;

    const DEAL_PENDING_CONFIRM_STATUS = 3;

    const DEAL_DEAD_STATUS = 4;

    const DEAL_CLOSED_STATUS = 5;

    const DEAL_SOLD_STATUS = 6;

}
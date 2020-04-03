<?php


namespace App\Repository;


interface FailedLoginInterface
{
    const IP_SESSION_MSG = 'User is session at different location please logout from all existing sessions';

    const LOCK_OUT_ID = 4;

    const LOCKED_MSG = 'Too many failed attempts please contact a Sein Analytics representative';

    const UPDATE_FAIL_ID = [
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 4
    ];
}
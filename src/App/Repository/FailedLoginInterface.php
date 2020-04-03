<?php


namespace App\Repository;


interface FailedLoginInterface
{
    const IP_SESSION_MSG = 'User is session at different location please logout from all existing sessions';

    const LOCK_OUT_ID = 4;

    const LOCKED_MSG = 'Too many failed attempts please contact a Sein Analytics representative';

    const FAILED_MSG = "Username and password combination is incorrect. Check combination and try again or contact a Sein representative";

    const PARAM_MSG = "Username or password was not properly submitted. Please try again";

    const UPDATE_FAIL_ID = [
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 4
    ];
}
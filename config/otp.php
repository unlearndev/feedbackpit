<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Code Length
    |--------------------------------------------------------------------------
    |
    | The number of digits used when generating a sign-in code.
    |
    */

    'length' => 6,

    /*
    |--------------------------------------------------------------------------
    | Code Expiry
    |--------------------------------------------------------------------------
    |
    | How long, in minutes, a sign-in code remains valid after it is sent.
    |
    */

    'expiry' => env('OTP_EXPIRY_MINUTES', 15),

];

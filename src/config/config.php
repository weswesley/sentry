<?php

return array (

    /*
    |--------------------------------------------------------------------------
    | Sentry Config
    |--------------------------------------------------------------------------
    |
    | Edit the list of roles below.  Make sure they match the roles in your
    | database.  These are case-insensitive as all roles get normalized to
    | lowercase before Sentry processes them.
    |
    */
    'roles' => [
        'guest',
        'administrator',
        'user',
    ],

    'defaults' => [
        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        |
        | The user role below will always have access to a resource even when not
        | specifically defined in Sentry::requireRole();
        |
        */
        'super_admin' => 'admin',


        /*
        |--------------------------------------------------------------------------
        | Guest User
        |--------------------------------------------------------------------------
        |
        | The user role below will always be treated as guest and be denied by
        | default unless specifically defined by Sentry::allow($role) or its
        | aliases.
        |
        */
        'stranger' => 'guest',
    ],




);
<?php

return [
    'tables' => [
        'polyteams' => 'polyteams',
        'polyteam_invites' => 'polyteam_invites',
        'polyteam_user' => 'polyteam_user',
        'users' => 'users',
    ],

    'models' => [
        'invite' => Mpociot\Teamwork\TeamInvite::class,
        'polyteam' => \IBroStudio\Polyteam\Models\Polyteam::class,
        'user' => config('auth.providers.users.model', \App\User::class),
    ],

    'user_foreign_key' => 'id',

    'use_slug_in_routes' => true,
];

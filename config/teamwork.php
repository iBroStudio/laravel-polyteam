<?php

return [
    'user_model' => config('polyteam.models.user'),
    'users_table' => config('polyteam.tables.users'),
    'team_model' => config('polyteam.models.polyteam'),
    'teams_table' => config('polyteam.tables.polyteams'),
    'team_user_table' => config('polyteam.tables.polyteam_user'),
    'user_foreign_key' => 'id',
    'invite_model' => config('polyteam.models.invite'),
    'team_invites_table' => config('polyteam.tables.polyteam_invites'),
];

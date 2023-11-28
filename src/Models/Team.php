<?php

namespace IBroStudio\PolymorphicTeam\Models;

use Mpociot\Teamwork\TeamworkTeam;
use Parental\HasChildren;

class Team extends TeamworkTeam
{
    use HasChildren;

    protected $fillable = ['type', 'name', 'owner_id'];
}

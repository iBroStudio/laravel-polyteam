<?php

namespace IBroStudio\Polyteam\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\PolymorphicTeam\Polyteam
 */
class Polyteam extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \IBroStudio\PolymorphicTeam\Polyteam::class;
    }
}

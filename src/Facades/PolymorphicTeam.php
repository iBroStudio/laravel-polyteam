<?php

namespace IBroStudio\PolymorphicTeam\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBroStudio\PolymorphicTeam\PolymorphicTeam
 */
class PolymorphicTeam extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \IBroStudio\PolymorphicTeam\PolymorphicTeam::class;
    }
}

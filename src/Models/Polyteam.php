<?php

namespace IBroStudio\Polyteam\Models;

use Mpociot\Teamwork\TeamworkTeam;
use Parental\HasChildren;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Polyteam extends TeamworkTeam
{
    use HasChildren;
    use HasSlug;

    protected $fillable = ['name', 'owner_id', 'slug', 'type'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        if (config('polyteam.use_slug_in_routes')) {
            return 'slug';
        }

        return parent::getRouteKeyName();
    }
}

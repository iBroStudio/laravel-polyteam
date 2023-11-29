<?php

namespace IBroStudio\Polyteam\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PolyteamCommand extends Command
{
    public $signature = 'make:polyteam {name}';

    public $description = 'Generate a polyteam';

    public function handle(): int
    {
        $model = trim($this->argument('name'));

        $this->call(ModelGenerator::class, ['name' => $model]);

        $this->call(UserTraitGenerator::class, ['name' => 'UserHas'.Str::plural($model)]);

        Schema::table(config('polyteam.tables.users'), function (Blueprint $table) use ($model) {
            $table->integer('current_' . Str::lower($model) . '_id')->unsigned()->nullable();
        });

        $this->comment('All done');

        return self::SUCCESS;
    }
}

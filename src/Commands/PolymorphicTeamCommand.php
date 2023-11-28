<?php

namespace IBroStudio\PolymorphicTeam\Commands;

use Illuminate\Console\Command;

class PolymorphicTeamCommand extends Command
{
    public $signature = 'polymorphic-team';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

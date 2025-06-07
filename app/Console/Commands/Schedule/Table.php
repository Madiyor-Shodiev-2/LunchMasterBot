<?php

namespace App\Console\Commands\Schedule;

use Illuminate\Console\Command;
use App\Actions\HandleTableAction;
use App\Models\LunchSchedule;

class Table extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:table {arg} {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $handleAction = new HandleTableAction();

        $handleAction->getHandleTable(
            $this,
            new LunchSchedule(),
            ['ID', 'name', 'hour', 'minute', 'max_per_round', 'active'],
            ['schedule_id', 'name', 'hour', 'minute', 'max_per_round', 'active']
        );
    }
}

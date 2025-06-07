<?php

namespace App\Console\Commands\Session;

use Illuminate\Console\Command;
use App\Actions\HandleTableAction;
use App\Models\LunchSession;
class Table extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:table {arg} {--id=*}';

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
        $method           = new LunchSession;

        $handleAction->getHandleTable(
            $this,
            $method,
            ['ID', 'schedule-id', 'date', 'status', 'created_at'],
            ['session_id', 'schedule_id', 'date', 'status', 'created_at']
        );
    }
}

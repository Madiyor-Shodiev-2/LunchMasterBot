<?php

namespace App\Console\Commands\QueueEntry;

use Illuminate\Console\Command;
use App\Actions\HandleTableAction;
use App\Models\QueueEntry;
class Table extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:table {arg} {--id=*}';

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
            new QueueEntry(),
            ['ID', 'session-id', 'operator-id',  'joined_at', 'position', 'status'],
            ['entry_id', 'session_id', 'operator_id', 'created_at', 'position', 'status']
        );
    }
}

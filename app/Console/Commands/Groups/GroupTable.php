<?php

namespace App\Console\Commands\Groups;

use Illuminate\Console\Command;
use App\Actions\HandleTableAction;
use App\Models\Group;

class GroupTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'group:table {arg} {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Это зделано для того чтобы создать группу для сессии';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new HandleTableAction)->getHandleTable(
            $this,
            new Group(),
            'group_id',
            ['ID', 'name'],
            ['group_id', 'name']
        );
    }
}

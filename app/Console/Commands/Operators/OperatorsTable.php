<?php

namespace App\Console\Commands\Operators;

use Illuminate\Console\Command;
use App\Actions\HandleTableAction;
use App\Models\Operator;
use Illuminate\Support\Facades\DB;

class OperatorsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operators:table {arg} {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Это зделано для того чтобы было можно посмотреть всех операторов или же добавляется возможность посмотреть по одного оператора или же несколько операторов сразу';

    /**
     * 
     */
    public function handle()
    {
        $handleAction = new HandleTableAction();
        $method       = new Operator();

        $handleAction->getHandleTable(
            $this,
            $method,
            'operator_id',
            ['operator_id', 'telegram_id', 'username', 'full_name', 'is_supervisor', 'joined_at'],
        ['operator_id', 'telegram_id', 'username', 'fullname', 'is_supervisor', 'created_at']
        );
    }
}

<?php 

namespace App\Actions;

use Illuminate\Console\Command;
use App\Actions\ScheduleCommandAction;
use App\Actions\SessionCommandAction;
class HandleTableAction
{    
    public function getHandleTable(Command $command, $method, string $primaryKey = 'id', array $columns, array $rows){
        /* 
        return [
            'default' => new TableStyle(),
            'markdown' => $markdown,
            'borderless' => $borderless,
            'compact' => $compact,
            'symfony-style-guide' => $styleGuide,
            'box' => $box,
            'box-double' => $boxDouble,
        ];
        /*/

        if ($command->argument('arg') == 'all') {
            $command->table(
                $columns,
                $method->all($rows)->toArray(),
                'borderless',
                ['box', 'borderless', 'box-double']
            );
        } elseif ($command->argument('arg') == 'show') {

            $data = $method->whereIn($primaryKey, $command->option('id'))
                ->get($rows)
                ->toArray();

            if ($data) {
                $command->table(
                    $columns,
                    $data,
                    'borderless',
                    ['box', 'borderless', 'box-double']
                );
            } else {
                $command->warn('Not finding operators');
            }
        } elseif ($command->argument('arg') == 'create') {
            if($primaryKey == 'schedule_id'){
                ScheduleCommandAction::scheduleStore($command);
            } elseif ($primaryKey == 'session_id'){
                SessionCommandAction::sessionStore($command);
            }
        } elseif ($command->argument('arg') == 'delete'){
            $method->destroy($command->option('id'));
        } elseif($command->argument('arg') == 'update'){
            
        }
    }

}
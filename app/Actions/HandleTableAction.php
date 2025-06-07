<?php 

namespace App\Actions;

use Illuminate\Console\Command;

class HandleTableAction
{    
    public function getHandleTable(Command $command, $method, array $columns, array $rows){
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
                $method->all()->except(['updated_at'])->toArray(),
                'borderless',
                ['box', 'borderless', 'box-double']
            );
        } elseif ($command->argument('arg') == 'show') {

            $operators = $method->whereIn('operator_id', $command->option('id'))
                ->get($rows)
                ->toArray();

            if ($operators) {
                $command->table(
                    $columns,
                    $operators,
                    'borderless',
                    ['box', 'borderless', 'box-double']
                );
            } else {
                $command->warn('Not finding operators');
            }
        }
    }

}
<?php

namespace App\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;

class GroupCommandAction
{
    public static function groupStore(Command $command){
        $lunchGroupName = $command->ask('Выберите имя для Ланч Группы');

        $data = [
            'name' => $lunchGroupName
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:32'
        ]);

        if($validator->fails()){
            $command->error($validator->getMessageBag());
        } else {
            Group::create($data);
        }
    }
}
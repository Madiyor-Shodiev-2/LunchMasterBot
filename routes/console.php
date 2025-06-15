<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\Notify\SendMessageToGroup;
use App\Console\Commands\Notify\SendAllOperatorsCommand;
use App\Console\Commands\Notify\SendAllSchedule;
use App\Console\Commands\Notify\SendAllSessionsCommand;

// Schedule::command(SendMessageToGroup::class)->everyMinute();
// Schedule::command(SendAllOperatorsCommand::class)->everyMinute();
Schedule::command(SendAllSessionsCommand::class)->everyMinute();
// Schedule::command(SendAllSchedule::class)->everyMinute();
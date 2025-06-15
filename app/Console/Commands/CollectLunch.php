<?php

namespace App\Console\Commands;

use App\Models\LunchSession;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class CollectLunch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lunch:collect {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавить доступных операторов';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // $sessions = LunchSession::find($this->argument('id'))->toArray();

        // dd($sessions);
        // $operators = Operator::all()->toArray();

        // dd($operators);

        // $today = now()->toDateString();

        // $already = LunchSession::where('date', $today)
        //     ->with('operators')
        //     ->get()
        //     ->pluck('operators.*.operator_id')
        //     ->flatten()
        //     ->unique()
        //     ->toArray();

        // $eligible = Operator::whereNotIn('operator_id', $already)->get();

        // $schedule = LunchSchedule::first()->toArray();
        // $selected = $eligible->take($schedule->max_per_round);

        // dd($already, $eligible, $schedule);
        // // $this->info("{$already}");
    }
}

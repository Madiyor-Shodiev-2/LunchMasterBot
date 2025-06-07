<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Command;


class LunchSchedule extends Model
{
    protected $table = "lunch_schedules";
    protected $primaryKey = 'schedule_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'hour',
        'minute',
        'max_per_round',
        'active'
    ];

    public function sessions() {
        return $this->hasMany(
            related: LunchSession::class,
            foreignKey: 'schedule_id',
            localKey: 'schedule_id'
        );
    }
}

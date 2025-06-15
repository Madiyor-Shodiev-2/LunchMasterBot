<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Console\Command;

class LunchSchedule extends Model
{
    protected $table = "lunch_schedules";
    protected $primaryKey = 'schedule_id';
    public $incrementing = true;

    protected $fillable = [
        'group_id',
        'hour',
        'minute',
        'max_per_round',
        'active'
    ];

    protected function hour(): Attribute
    {
        return Attribute::make(
            get: fn(int $value): string => gmdate('H:i', $value)
        );
    }

    public function sessions() {
        return $this->hasMany(
            related: LunchSession::class,
            foreignKey: 'schedule_id',
            localKey: 'schedule_id'
        );
    }

    public function group()
    {
        return $this->belongsTo(
            related: Group::class,
            foreignKey: 'group_id',
            ownerKey: 'group_id'
        );
    }
}

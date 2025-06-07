<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LunchSession extends Model
{
    protected $table = "lunch_sessions";
    protected $primaryKey = 'session_id';
    public $incrementing = true;
    protected $fillable = [
        'schedule_id',
        'date',
        'status'
    ];

    public function schedule(){
        return $this->belongsTo(
            related: LunchSchedule::class,
            foreignKey: 'schedule_id',
            ownerKey: 'schedule_id'
        );
    }

    public function operators(){
        return $this->belongsToMany(
            related: Operator::class,
            table: 'queue_entries', 
            foreignPivotKey: 'session_id', 
            relatedPivotKey: 'operator_id'
        );
    }
}

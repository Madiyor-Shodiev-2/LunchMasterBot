<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueueEntry extends Model
{
    protected $table = 'queue_entries';
    protected $primaryKey = 'entry_id';
    public $incrementing = true;
    protected $fillable = [
        'session_id',
        'operator_id',
        'position',
        'status'
    ];

    public function session(){
        return $this->belongsTo( LunchSession::class, 'session_id', 'session_id');
    }

    public function operator(){
        return $this->belongsTo( Operator::class, 'operator_id', 'operator_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operators';
    protected $primaryKey = 'operator_id';
    protected $keyType = 'biginit';
    public $incrementing = true;
    protected $fillable = [
        'username',
        'fullname',
        'is_supervisor'
    ];


    public function sessions(){
        return $this->belongsToMany(
            related: LunchSession::class,
            table: 'queue_entries',
            foreignPivotKey: 'operator_id',
            relatedPivotKey: 'session_id'
        );
    }
}

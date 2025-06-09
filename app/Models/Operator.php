<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class Operator extends Model
{
    protected $table = 'operators';
    protected $primaryKey = 'operator_id';
    public $incrementing = true;
    protected $fillable = [
        'telegram_id',
        'username',
        'fullname',
        'is_supervisor'
    ];

    protected function isSupervisor(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => empty($value) ? "no" : "yes"
        );
    }

    public function sessions(){
        return $this->belongsToMany(
            related: LunchSession::class,
            table: 'queue_entries',
            foreignPivotKey: 'operator_id',
            relatedPivotKey: 'session_id'
        );
    }
}

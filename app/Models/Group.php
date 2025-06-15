<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = "groups";
    protected $primaryKey = "group_id";
    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(
            related: LunchSchedule::class,
            foreignKey: 'group_id',
            localKey: 'group_id'
        );
    }
}

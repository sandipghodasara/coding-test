<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($phase) {
            $phase->tasks()->delete();
        });
    }

    function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

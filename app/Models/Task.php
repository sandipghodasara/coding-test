<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'name',
        'phase_id',
        'user_id',
        'completed_at'
    ];

    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($task) {
            $newPhaseId = $task->phase_id;

            $newPhase = Phase::query()->find($newPhaseId);
            if ($newPhase->name == "completion" && empty($task->completed_at)){
                $task->completed_at = Carbon::now();
            }
        });
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function phase()
    {
        return $this->belongsTo(Phase::class);
    }
}

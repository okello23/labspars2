<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    protected $fillable = [
        'run_id',
        'facility',
        'status',
        'commit',
        'branch',
        'actor',
        'started_at',
        'finished_at',
        'duration_seconds',
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    /**
     * Compute and store duration when finishing a deployment.
     */
    public function finish(string $status): void
    {
        $this->finished_at      = now();
        $this->status           = $status;
        $this->duration_seconds = $this->started_at
            ? (int) $this->started_at->diffInSeconds(now())
            : null;
        $this->save();
    }
}
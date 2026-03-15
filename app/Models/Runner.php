<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    protected $fillable = ['facility', 'status', 'last_heartbeat'];

    protected $casts = [
        'last_heartbeat' => 'datetime',
    ];

    /**
     * Mark runner as online and update heartbeat timestamp.
     */
    public static function heartbeat(string $facility): self
    {
        return static::updateOrCreate(
            ['facility' => $facility],
            ['status' => 'online', 'last_heartbeat' => now()]
        );
    }

    /**
     * Mark stale runners (no heartbeat in 10 minutes) as offline.
     * Called by the scheduled command.
     */
    public static function markStaleAsOffline(): void
    {
        static::where('last_heartbeat', '<', now()->subMinutes(10))
              ->where('status', '!=', 'offline')
              ->update(['status' => 'offline']);
    }
}
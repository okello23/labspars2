<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Runner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RunnerController extends Controller
{
    /**
     * GET /api/runners
     * Returns the current status of all known runners.
     */
    public function index(): JsonResponse
    {
        // Mark stale runners offline before returning
        Runner::markStaleAsOffline();

        $runners = Runner::orderBy('facility')->get()->map(fn ($r) => [
            'facility'   => $r->facility,
            'status'     => $r->status,
            'last_seen'  => $r->last_heartbeat?->toISOString(),
        ]);

        return response()->json($runners);
    }

    /**
     * POST /api/runners/heartbeat
     * Each facility server calls this every 5 minutes via cron
     * to signal it is alive.
     */
    public function heartbeat(Request $request): JsonResponse
    {
        $data = $request->validate([
            'facility' => 'required|string',
        ]);

        $runner = Runner::heartbeat($data['facility']);

        return response()->json([
            'facility' => $runner->facility,
            'status'   => $runner->status,
            'message'  => 'Heartbeat recorded',
        ]);
    }

    /**
     * GET /api/stats
     * Summary counts — used by the dashboard header cards.
     */
    public function stats(): JsonResponse
    {
        $deployments = \App\Models\Deployment::selectRaw(
            'status, COUNT(*) as count'
        )->groupBy('status')->pluck('count', 'status');

        $total   = $deployments->sum();
        $success = $deployments->get('success', 0);
        $failed  = $deployments->get('failed', 0);
        $running = $deployments->get('running', 0);
        $finished = $success + $failed;

        return response()->json([
            'total'        => $total,
            'success'      => $success,
            'failed'       => $failed,
            'running'      => $running,
            'success_rate' => $finished > 0 ? round($success / $finished * 100) : 0,
        ]);
    }
}
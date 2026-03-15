<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Deployment;
use App\Models\Runner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeploymentController extends Controller
{
    /**
     * GET /api/deployments
     * Returns recent deployments, optionally filtered by facility or status.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Deployment::query()->latest('started_at');

        if ($request->filled('facility')) {
            $query->where('facility', $request->facility);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $deployments = $query->limit(200)->get();

        return response()->json($deployments);
    }

    /**
     * POST /api/deployments
     * Called by the runner at the START of a deployment.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'run_id'     => 'required|string',
            'facility'   => 'required|string',
            'status'     => ['required', Rule::in(['running', 'success', 'failed'])],
            'commit'     => 'nullable|string|max:40',
            'branch'     => 'nullable|string',
            'actor'      => 'nullable|string',
            'started_at' => 'nullable|date',
        ]);

        $deployment = Deployment::updateOrCreate(
            ['run_id' => $data['run_id']],
            array_merge($data, [
                'started_at' => $data['started_at'] ?? now(),
            ])
        );

        // Update runner heartbeat — if it's posting, it's alive
        Runner::heartbeat($data['facility']);

        return response()->json($deployment, 201);
    }

    /**
     * PATCH /api/deployments/{runId}
     * Called by the runner at the END of a deployment (success or failure).
     */
    public function update(Request $request, string $runId): JsonResponse
    {
        $data = $request->validate([
            'facility'    => 'required|string',
            'status'      => ['required', Rule::in(['success', 'failed'])],
            'finished_at' => 'nullable|date',
        ]);

        $deployment = Deployment::where('run_id', $runId)->firstOrFail();
        $deployment->finish($data['status']);

        // Update runner — still alive after finishing
        Runner::heartbeat($data['facility']);

        return response()->json($deployment);
    }
}
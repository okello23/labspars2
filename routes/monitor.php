<?php

use App\Http\Controllers\API\DeploymentController;
use App\Http\Controllers\API\RunnerController;
use App\Http\Middleware\VerifyMonitorApiKey;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Monitoring API Routes
|--------------------------------------------------------------------------
|
| All routes are protected by the X-Monitor-Key header.
| Add this file's routes to your bootstrap/app.php or routes/api.php.
|
*/

Route::middleware([VerifyMonitorApiKey::class])->group(function () {

    // ── Deployments ──────────────────────────────────────────────────────
    Route::get('deployments',          [DeploymentController::class, 'index']);
    Route::post('deployments',         [DeploymentController::class, 'store']);
    Route::patch('deployments/{runId}', [DeploymentController::class, 'update']);

    // ── Runners ──────────────────────────────────────────────────────────
    Route::get('runners',              [RunnerController::class, 'index']);
    Route::post('runners/heartbeat',   [RunnerController::class, 'heartbeat']);

    // ── Stats (dashboard summary cards) ──────────────────────────────────
    Route::get('stats',                [RunnerController::class, 'stats']);

});
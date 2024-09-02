<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Api\ApiComponent;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use App\Http\Livewire\Microbiology\SamplesComponent;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ApiAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['auth:api']], function () {

  Route::get('dhis2/facilities', ApiComponent::class)->name('facilities');
  // Route::get('/samples', SamplesComponent::class,'poi')->name('microbiology-samples');

});

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
], function () {
    // Passport routes...
    Route::get('/samples', [SamplesComponent::class, 'poi'])->name('microbiology-samples');

});


Route::group([
    'as' => 'microbiology.',
    'prefix' => config('passport.path', 'microbiology'),
], function () {
    // Passport routes...
    // Route::get('/samples', [SamplesComponent::class, 'poi'])->name('microbiology-samples');
    Route::post('/test-request', [SamplesComponent::class, 'receiveSampleFromApi'])->middleware(['auth:api','scope:make-test-request']);

});


Route::post('/login', [ApiAuthController::class,'login']);
Route::post('/register', [ApiAuthController::class,'register']);

// Route::post('/login', 'Auth\UserAuthController@login');

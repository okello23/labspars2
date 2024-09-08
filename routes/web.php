<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Livewire\Settings\RegionsComponent;
use App\Http\Livewire\Settings\CountiesComponent;
use App\Http\Livewire\Settings\DistrictsComponent;
use App\Http\Livewire\Settings\SubCountiesComponent;
use App\Http\Livewire\Dashboard\MainDashboardComponent;
use App\Http\Livewire\UserManagement\UserProfileComponent;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Facility\FacilityComponent;
use App\Http\Livewire\Facility\Visits\FacilityVisitDetailsComponent;
use App\Http\Livewire\Facility\Visits\FacilityVisitsComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::get('user/account', UserProfileComponent::class)->name('user.account')->middleware('auth');

Route::get('lang/{locale}', function ($locale) {
  if (array_key_exists($locale, config('languages'))) {
    Session::put('locale', $locale);
  }

  return redirect()->back();
})->name('lang');

Route::group(['middleware' => ['auth', 'password_expired', 'suspended_user']], function () {

  // Route::get('/home', function () {
    //     return view('home');
    //   })->middleware(['auth', 'verified'])->name('home');
    Route::get('dashboard', MainDashboardComponent::class)->name('home');

    Route::group(['prefix' => 'admin'], function () {
      //User Management
      Route::get('/manage', function () {
        return view('admin.dashboard');
      })->middleware(['auth', 'verified'])->name('admin-dashboard');
      Route::group(['prefix' => 'manage'], function () {
      Route::get('regions', RegionsComponent::class)->name('regions');
      Route::get('districts', DistrictsComponent::class)->name('districts');
      Route::get('counties', CountiesComponent::class)->name('county');
      Route::get('sub-counties', SubCountiesComponent::class)->name('sub-county');
      });
      Route::group(['prefix' => 'facility'], function () {
        Route::get('list', FacilityComponent::class)->name('facility');
        Route::get('visits', FacilityVisitsComponent::class)->name('facility-visits');
        Route::get('details/{code}', FacilityVisitDetailsComponent::class)->name('facility-visit_details');
      });
      require __DIR__.'/user_mgt.php';
    });
  });

  require __DIR__.'/auth.php';

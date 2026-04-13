<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserRolesController;
use App\Http\Livewire\UserManagement\UsersComponent;
use App\Http\Controllers\Auth\UserPermissionsController;
use App\Http\Livewire\UserManagement\UserActivityComponent;
use App\Http\Controllers\Auth\UserRolesAssignmentController;
use App\Http\Livewire\UserManagement\LoginActivityComponent;
use App\Http\Livewire\CompanyProfile\CompanyProfileComponent;
use App\Http\Livewire\UserManagement\UserProfileComponent;

Route::group(['prefix' => 'user-mgt', 'middleware' => ['permission:access_user_management']], function () {
    Route::get('users', UsersComponent::class)->name('usermanagement')->middleware('permission:view_user');
    Route::resource('user-roles', UserRolesController::class)->middleware('permission:view_role');
    Route::resource('user-permissions', UserPermissionsController::class)->middleware('permission:view_permission');
    Route::resource('user-roles-assignment', UserRolesAssignmentController::class)->middleware('permission:assign_role');
    Route::get('activityTrail', UserActivityComponent::class)->name('useractivity')->middleware('permission:view_activity_trail');
    Route::get('loginActivity', LoginActivityComponent::class)->name('logs')->middleware('permission:view_login_activity');
});

Route::get('company-profile', CompanyProfileComponent::class)->name('company-profile')->middleware('permission:access_user_management');
Route::get('user-profile', UserProfileComponent::class)->name('profile');

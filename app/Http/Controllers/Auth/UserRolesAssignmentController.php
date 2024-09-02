<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Laratrust\Helper;

// use Illuminate\Support\Facades\Config;

class UserRolesAssignmentController
{
    protected $rolesModel;

    protected $permissionModel;

    protected $assignPermissions;

    public function __construct()
    {
        $this->rolesModel = config('laratrust.models.role');
        $this->permissionModel = config('laratrust.models.permission');
        $this->assignPermissions = config('laratrust.panel.assign_permissions_to_user');
    }

    public function index(Request $request)
    {
        $modelsKeys = array_keys(config('laratrust.user_models'));
        $modelKey = $request->get('model') ?? $modelsKeys[0] ?? null;
        $userModel = config('laratrust.user_models')[$modelKey] ?? null;

        if (! $userModel) {
            abort(404);
        }

        return View::make('livewire.user-management.access.rolesAssignment', [
            'models' => $modelsKeys,
            'modelKey' => $modelKey,
            'users' => $userModel::query()
                ->withCount(['roles', 'permissions'])
                ->latest()->get(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $modelKey = $request->get('model');
        $userModel = config('laratrust.user_models')['users'] ?? null;

        if (! $userModel) {
            return redirect(route('user-roles-assignment.index'))->with('error', 'Model was not specified in the request');
        }

        $user = $userModel::query()
            ->with(['roles:id,name', 'permissions:id,name'])
            ->findOrFail($id);

        $roles = $this->rolesModel::orderBy('name')->get(['id', 'name', 'display_name'])
            ->map(function ($role) use ($user) {
                $role->assigned = $user->roles
                ->pluck('id')
                    ->contains($role->id);
                $role->isRemovable = Helper::roleIsRemovable($role);

                return $role;
            });
        if ($this->assignPermissions) {
            $permissions = $this->permissionModel::all(['id', 'name', 'display_name', 'target_module'])
                ->map(function ($permission) use ($user) {
                    $permission->assigned = $user->permissions
                        ->pluck('id')
                        ->contains($permission->id);

                    return $permission;
                })->groupBy('target_module');
        }

        return View::make('livewire.user-management.access.editRoleAssignment', [
            'modelKey' => $modelKey,
            'roles' => $roles,
            'permissions' => $this->assignPermissions ? $permissions : null,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $modelId)
    {
        $modelKey = $request->get('model');
        $userModel = config('laratrust.user_models')['users'] ?? null;

        if (! $userModel) {
            return redirect()->back()->with('error', 'Model was not specified in the request');
        }

        $user = $userModel::findOrFail($modelId);
        $authUser = $userModel::findOrFail(auth()->user()->id);
        $user->syncRoles($request->get('roles') ?? []);
        activity()
            ->causedBy($authUser)
            ->performedOn($user)
            ->useLog('users')
            ->event('Assigned Role')
            ->withProperties(['roles' => $request->get('roles') ?? []])
            ->log('Assigned Role');

        if ($this->assignPermissions) {
            $user->syncPermissions($request->get('permissions') ?? []);
            activity()
            ->causedBy($authUser)
            ->performedOn($user)
            ->useLog('users')
            ->event('Assigned Permission')
            ->withProperties(['permissions' => $request->get('permissions') ?? []])
            ->log('Assigned Permission');
        }

        return redirect(route('user-roles-assignment.index', ['model' => $modelKey]))->with('success', 'Roles and permissions assigned successfully');
    }
}

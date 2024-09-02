<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserPermissionsController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = config('laratrust.models.permission');
    }

    public function index()
    {
        return View::make('livewire.user-management.access.userPermissions', ['permissions' => $this->permissionModel::get()]);
    }

    // public function create()
    // {
    //     return View::make('laratrust::panel.edit', [
    //         'model' => null,
    //         'permissions' => null,
    //         'type' => 'permission',
    //     ]);
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        try {
            $permission = $this->permissionModel::create($data);

            return to_route('user-permissions.index')->with('success', 'Permission created successfully!');
        } catch (\exception $error) {
            return redirect()->back()->with('error', 'Permission already exists!');
        }
    }

    public function edit($id)
    {
        if (Auth::user()->hasPermission(['update_permission'])) {
            $permission = $this->permissionModel::findOrFail($id);

            return View::make('livewire.user-management.access.editRolePermission', [
                'model' => $permission,
                'type' => 'permission',
            ]);
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        try {
            $permission->update($data);

            return to_route('user-permissions.index')->with('success', 'Permission updated successfully!');
        } catch (\exception $error) {
            return redirect()->back()->with('error', 'Permission name already taken!');
        }
    }
}

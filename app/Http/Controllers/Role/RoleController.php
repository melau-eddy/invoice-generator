<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Service\RoleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class Role Controller
 */
class RoleController extends Controller
{
    /**
     * @param RoleService $roleService
     */
    public function __construct(protected RoleService $roleService)
    {
    }


    /**
     * Displaying list of roles
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index()
    {
        try {
            $roles = $this->roleService->index();
            return view('Roles.RoleView')->with('result', $roles)->with('status', 'Search Results');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function create()
    {
        try {
            $permissions = $this->roleService->create();
            return view('Roles.RoleForm', compact('permissions'));
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     * Store a newly created role in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function store(RoleRequest $request)
    {
        try {
            if (Auth::user()->can('manage_role')) {
                DB::beginTransaction();
                $role = $this->roleService->store([
                    'name' => $request->name
                ]);
                $permissions = $request->permissions;
                foreach ($permissions as $permission) {
                    $role->givePermissionTo($permission);
                }
                DB::commit();
                return redirect()->route('role.index')->with('status', 'Role Created Successfully');
            } else {
                return view('Role.RoleForm');
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }


    /**
     *  Show the form for editing the specified role.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function edit($id)
    {
        try {
            if (Auth::user()->can('manage_role')) {
                $role = Role::findorfail($id);
                $permissions = Permission::all();
                $roles_permissions = DB::table('role_has_permissions')->where('role_id', $id)->get();
                $selectedperm = [];
                foreach ($roles_permissions as $rolepermission) {
                    $selectedperm[] = $rolepermission->permission_id;
                }
                return view('Roles.RoleForm', compact('role', 'permissions', 'selectedperm'));
            } else {
                return view('Roles.RoleForm');
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }

    }

    /**
     * Update the specified role in storage.
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function update(RoleRequest $request, $id)
    {
        try {
            if (Auth::user()->can('manage_role')) {
                DB::beginTransaction();
                $role = Role::findorfail($id);
                $this->roleService->update([
                    "name" => $request->name
                ], $id);
                $permissions = $request->permissions;
                $perm = [];
                foreach ($permissions as $permission) {
                    $perm[] = $permission;
                    $role->permissions()->sync($perm);
                }
                $role->save();
                DB::commit();
                return redirect()->route('role.index')->with('status', 'Role Updated Successfully');
            } else {
                return view('Roles.RoleForm');
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }

    }

    /**
     * Remove the specified role from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->destroy($id);
            DB::commit();
            return redirect()->route('role.index');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('error_msg', $exception);
        }
    }
}

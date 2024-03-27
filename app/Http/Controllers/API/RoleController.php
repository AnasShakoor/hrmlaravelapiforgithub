<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return response()->json([
            'message' => 'this is the list of all roles',
            'role'    => $roles,
        ]);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|unique:roles,name',
            ]);

            $role = Role::create(['name' => $request->name]);

            if ($request->has('create')) {
                $role->givePermissionTo('create');
            }
            if ($request->has('list')) {
                $role->givePermissionTo('list');
            }

            if ($request->has('delete')) {
                $role->givePermissionTo('delete');
            }

            if ($request->has('update')) {
                $role->givePermissionTo('update');
            }
            DB::commit();

            // return to your desired page
            //  return view('roles.index', compact('roles'));

            //   uncomment me to check if the api is  working
            return response()->json([
                'message' => 'Your role has been created with permission',
                'role'    => $role,
                // 'permissions' => $request->permissions->pluck('name')->toArray(),

            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'There is some error',
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, Role $role)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|unique:roles,name,'.$role->id,
                // 'guard_name' => 'nullable|string',
            ]);

            $role->update($request->all());

            DB::commit();

            return response()->json([
                'message' => 'It is updated ',
                'role'    => $role,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'There is some error',
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Role $role)
    {
        DB::beginTransaction();

        try {
            $role->delete();

            // return redirect ()->route('')->with('success','DEleted succsessfully');
            return response()->json([
                'message' => 'your roll is deleted',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'there is some error',
                'error'   => $e->getMessage(),
            ]);
        }
    }
}

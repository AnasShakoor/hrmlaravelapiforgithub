<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; // Add this line

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        //    dd($roles);
        return response()->json([
            'message' => 'these are the all permissions',
            'role'    => $permissions,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required',
            ]);

            $Permission = Permission::create(['name' => $request->name]);
            DB::commit();

            return response()->json([
                'message'    => 'you permission has been added ',
                'permission' => $Permission,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'there is some error',
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|unique:permissions,name,',
                // 'guard_name' => 'nullable|string',
            ]);

            $Permission = Permission::findOrFail($id);
            $Permission->name = $request->name;
            $Permission->save();

            DB::commit();

            return response()->json([
                'message'           => 'your value is updated',
                'updatedpermission' => $Permission,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => 'There is some error',
                'error'   => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Permission $permission)
    {
        DB::beginTransaction();

        try {
            $permission->delete();

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Permission deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status'  => 'error',
                'message' => 'There was an error deleting the permission',
                'error'   => $e->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function __construct()
    {
           // Apply middleware to all methods in the controller
        $this->middleware('checkPermission:delete_files');
    }


    public function assignrole(Request $request)
    {



        $role = Role::where('name', 'guard')->first();
        $role->givePermissionTo('delete_files');
    }
    public function getrole()

    {
        // try {
        //     $user = User::find(6);

        //     // Check if the user has the 'guard' role
        //     return response()->json([
        //         'message' => 'User is found',
        //         'has_guard_role' => 'you have the guard role in your life'
        //     ]);
        //     $hasGuardRole = $user->hasRole('guard');
        //         $authuser = Auth::check();
        //             if ($authuser) {
        //                 // User is authenticated, perform actions or show content for authenticated users.
        //                 return response()->json([
        //                     'message' => 'you are logged in'
        //                 ] 
        //                 );
        //             } else {
        //                 // User is not authenticated, handle accordingly (e.g., redirect to login page).\
        //                 return response()->json([
        //                     'message' => 'you are not logged in '
        //                 ] 
        //                 );
        //             }


        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => 'An error occurred',
        //         'error' => $e->getMessage(),
        //     ]);
        // }                             

        try {
            $role = Role::where('name', 'delete_files')->first();
            $role->delete();
            return response()->json([
                'message' => 'this role is deleted',
                // 'has_guard_role' => 'you have the guard role in your life'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */




     
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'user_type' => ['required']
        ]);
    
        // Check if password is present
        if (empty($request->password)) {
            $errors = ['password' => ['The password field is required.']];
            return $this->sendError('Validation Error', $errors, 422);
        }
    
        DB::beginTransaction();
    
        try {
            // Attempt basic email and password authentication
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
    
                // Check if user_type matches
                if ($user->user_type === $request->user_type) {
                    $success['token'] = $user->createToken('Auth_Token')->plainTextToken;
                    $success['name'] = $user->name;
    
                    DB::commit();
                    return $this->sendResponse($success, 'User login successfully to HRM.');
                } else {
                    DB::rollback();
                    $errors = ['user_type' => ['Invalid user type.']];
                    return $this->sendError('Unauthorized', $errors, 401);
                }
            } else {
                DB::rollback();
                $errors = ['credentials' => ['Invalid email or password.']];
                return $this->sendError('Invalid credentials', $errors, 401);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error',
                'error' => $e->getMessage(),
            ]);
        }
    
    
    }
}

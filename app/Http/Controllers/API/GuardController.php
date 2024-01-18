<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\storage;
use App\Models\Guard;
use App\Http\Requests\CreateGuardRequest;
use App\Http\Requests\CreateUserRequest;

class GuardController extends Controller
{

    public function index()
    {
        $guards = Guard::all();


        foreach ($guards as $guard) {
            $guardduty2 = $guard->user;
            $guardduty3 = $guard->guardsduty;
            $photourl = asset("storage/{$guard->photo}");
            $guard->photo = $photourl;

            $passporturl = asset("storage/{$guard->passport}");
            $guard->passport = $passporturl;

            $resumeurl = asset("storage/{$guard->resume}");
            $guard->resume = $resumeurl;

            $emirates_id_photourl = asset("storage/{$guard->emirates_id_photo}");
            $guard->emirates_id_photo = $emirates_id_photourl;
        }
        return response()->json([
            'message' => 'This is the list of all guards',
            'guards' => $guards,
        ]);
    }

    public function store(CreateGuardRequest $guardrequest, CreateUserRequest $userrequest)
    {
        DB::beginTransaction();
        $guarddata = $guardrequest->validated();
        $userdata = $userrequest->validated();
        $newuserdata = [
            'password' => '12345678',
            'user_type' => 'guard',
            'user_status' => 'active'
        ];

        $mergeduserdata = array_merge($userdata, $newuserdata);
        if ($guardrequest->hasFile('photo')) {
            $photofile = $guardrequest->file('photo');
            $photopath = $photofile->store('company_files', 'public');
            $guarddata['photo'] = $photopath;
        }
        if ($guardrequest->hasFile('passport')) {
            $photofile = $guardrequest->file('passport');
            $passportpath = $photofile->store('company_files', 'public');
            $guarddata['passport'] = $passportpath;
        }
        if ($guardrequest->hasFile('resume')) {
            $photofile = $guardrequest->file('resume');
            $resumepath = $photofile->store('company_files', 'public');
            $guarddata['resume'] = $resumepath;
        }
        if ($guardrequest->hasFile('emirates_id_photo')) {
            $photofile = $guardrequest->file('emirates_id_photo');
            $emirates_id_photopath = $photofile->store('company_files', 'public');
            $guarddata['emirates_id_photo'] = $emirates_id_photopath;
        }
        try {
            $newuser = User::create($mergeduserdata);
            $companyName = $guarddata['company'];
            $company = Company::where('name', $companyName)->first();

            $newguard = $newuser->guards()->create(array_merge($guarddata, ['company_id' => $company->id]));

            DB::commit();
            return response()->json([
                'message' => 'The guard is created easily',
                'guard' => $newguard,
                'user' => $newuser,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error ',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function show(string $id)
    {
        $guard = Guard::with(['user',])->findOrFail($id);
        $guardduty3 = $guard->guardsduty;

        $photourl = asset("storage/{$guard->photo}");
        $guard->photo = $photourl;

        $passporturl = asset("storage/{$guard->passport}");
        $guard->passport = $passporturl;

        $resumeurl = asset("storage/{$guard->resume}");
        $guard->resume = $resumeurl;

        $emirates_id_photourl = asset("storage/{$guard->emirates_id_photo}");
        $guard->emirates_id_photo = $emirates_id_photourl;


        return response()->json(['guard' => $guard], 200);
    }

    public function update(CreateGuardRequest $guardrequest,  Guard $guard)
    {
        $updatedguard = $guardrequest->validated();
        DB::beginTransaction();
        if ($guardrequest->hasFile('photo')) {
            Storage::disk('public')->delete($guard->file);
            $photofile = $guardrequest->file('photo');
            $photopath = $photofile->store('company_files', 'public');
            $guarddata['photo'] = $photopath;
        }
        if ($guardrequest->hasFile('passport')) {
            Storage::disk('public')->delete($guard->file);
            $photofile = $guardrequest->file('passport');
            $passportpath = $photofile->store('company_files', 'public');
            $guarddata['passport'] = $passportpath;
        }
        if ($guardrequest->hasFile('resume')) {
            Storage::disk('public')->delete($guard->file);
            $photofile = $guardrequest->file('resume');
            $resumepath = $photofile->store('company_files', 'public');
            $guarddata['resume'] = $resumepath;
        }
        if ($guardrequest->hasFile('emirates_id_photo')) {
            Storage::disk('public')->delete($guard->file);
            $photofile = $guardrequest->file('emirates_id_photo');
            $emirates_id_photopath = $photofile->store('company_files', 'public');
            $guarddata['emirates_id_photo'] = $emirates_id_photopath;
        }
        try {

            $companyname = $updatedguard['company'];
            $company = Company::where('name', $companyname)->first();
            $guard->update(array_merge($updatedguard, ['company_id' => $company->id]));
            DB::commit();
            return response()->json([
                'message' => 'Guard has been updated',
                'guard' => $guard,


            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error ',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function destroy(Guard $guard)
    {
        DB::beginTransaction();
        try {
            $guard->forceDelete();
            if ($guard->user) {
                $guard->user->forceDelete();
            }
            if ($guard->guardsduty) {
                $guard->guardsduty->forceDelete();
            }
            DB::commit();
            return response()->json([
                'message' => 'Guard and associated user (if exists) deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error',
                'error' => $e->getMessage(),
            ]);
        }
    }
}

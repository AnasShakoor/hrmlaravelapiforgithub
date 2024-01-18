<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\CreateUserRequest;

class CompanyController extends Controller
{


    public function index()
    {
        $companies = Company::all();
        foreach ($companies as $company) {
            $user = $company->user;
            $url = asset("storage/{$company->file}");
            $company->file = $url;
        }

        return response()->json([
            'companies' => $companies,
        ], 200);
    }

    public function show(string $id)
    {
        $company = Company::with('user')->findOrFail($id);
         $url = asset("storage/{$company->file}");
         $company->file = $url;
        return response()->json(['company' => $company], 200);
    }
    public function store(CreateCompanyRequest $companyRequest, CreateUserRequest $userRequest)
    {
        $companydata = $companyRequest->validated();
        $userdata = $userRequest->validated();
                DB::beginTransaction();
        try {
            $additionalUserData = [
                'password' => '12345678',
                'user_type' => 'company',
                'user_status' => 'abc'
            ];
            $companyfile = $companyRequest->file('file');
            $path = $companyfile->store('company_files', 'public');
            $companydata['file'] = $path;
            $mergedUserData = array_merge($userdata, $additionalUserData);
            $newuser = User::create($mergedUserData);
            $newcompany = $newuser->company()->create($companydata);
            if ($newcompany->status == 'active') {
                $user_status = 'active';
            } else {
                $user_status = 'inactive';
            }

            $newuser->update(['user_status' => $user_status]);
            DB::commit();
            return response()->json([
                'message' => 'The new user and the new company is created',
                'user' => $newuser,
                'company' => $newcompany
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error creating the company and user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function update(CreateCompanyRequest $companyrequest,  Company $company,)
    {

        $updatedcompany = $companyrequest->validated();
        DB::beginTransaction();
        try {
            if ($companyrequest->hasFile('file')) {
                Storage::disk('public')->delete($company->file);
                $newCompanyfile = $companyrequest->file('file');
                $newfilepath = $newCompanyfile->store('company_files','public');
                 $updatedcompany['file'] = $newfilepath;
            }
            $company->update($updatedcompany);
            DB::commit();
            return response()->json([
                'message' => 'The company have been updated',
                'company' => $company
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Company $company)
    {
        try {
            DB::beginTransaction();
            
            $company->guards()->forceDelete();
            
            $company->user()->forceDelete();
            
            $company->forceDelete();
            DB::commit();
            return response()->json([
                'message' => 'Company  associated,  user and guards(if exists) deleted successfully',

            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error deleting the company and associated user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

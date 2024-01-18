<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Policy;
use App\Models\User;
use App\Models\Guard;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreatePolicyRequest;

class PolicyController extends Controller
{
 
    public function index()
    {
        $policy = Policy::all();
        return response()->json([
            'message' => 'this is the list of all policies',
            'Policies' => $policy
        ], 200);
    }
    public function store(CreatePolicyRequest $request)
    {
        dd($request->all());

        DB::beginTransaction();


        $policydata = $request->validated();
             
        try {
            $newpolicy = Policy::create($policydata);

            DB::commit();
            return response()->json([
                'message' => 'The new policy is created ',
                'this is policy' => $newpolicy
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error creating the policy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        $policy = Policy::find($id);
        return response()->json([
            'message' => 'this is your policy ',
            'policy' => $policy
        ], 200);
    }

    
    public function update(CreatePolicyRequest $request, string $id)
    {
        DB::beginTransaction();
        $policy = policy::find($id);
        $policydata = $request->validated();
        $newpolicy = $policy->update($policydata);

        try {

            DB::commit();
            return response()->json([
                'message' => 'the policy is updated',
                'newpolicy' => $policy
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error updating the policy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        DB::beginTransaction();
        try {

            $policy->forceDelete();
            DB::commit();
            return response()->json([
                'message' => 'The policy is deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error creating the policy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

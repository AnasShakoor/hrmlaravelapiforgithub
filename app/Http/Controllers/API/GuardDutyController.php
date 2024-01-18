<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Models\Guard;
use App\Models\GuardDuty;
use App\Http\Requests\CreateGuardRequest;
use App\Http\Requests\CreateGuardDutyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuardDutyController extends Controller
{
    public function index()
    {
        $guardduty = GuardDuty::all();
       
        return response()->json([
            'message ' => 'this is the list of all duties',
        ]);
    }

  
    public function store(CreateGuardDutyRequest $request)
    {


        DB::beginTransaction();
        try {
            $guarddutydata = $request->validated();
            $associatedguard = Guard::where('emirates_id_number', $guarddutydata['emirates_id'])->first();

            $guardduty = GuardDuty::create(array_merge($guarddutydata, ['guard_id' => $associatedguard->id]));
            DB::commit();

            return response()->json([
                'message' => 'new guatd duty is assigned',
                'guardduty' => $guardduty
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
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

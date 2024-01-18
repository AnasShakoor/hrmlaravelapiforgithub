<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Resignation;
use App\Models\Guard;
use App\Models\Company;
use App\Http\Requests\ResignationRequest;

class ResignationController extends Controller
{
    public function index()
    {
        $resignation = Resignation::all();
        return response()->json([
            'message' => ' this is the list of all resigned guards',
            'all resignations ' => $resignation
        ]);
    }

    public function store(ResignationRequest $request)
    {

        $Resignationdata = $request->validated();
        $guard = Guard::where('name', $Resignationdata['guard_name'])->first();     
        DB::beginTransaction();
        try {
            if ($guard) {


                $isallowed = $request->input('allow_resign', false);
                if ($isallowed) {
                    $newresignation = Resignation::create($Resignationdata);
                    $guard->company()->dissociate();
                    DB::commit();
                    return response()->json([
                        'message' => 'The new resignation is created and you data will be updated soon',
                        'resignation' => $newresignation,
                        'guard' => $guard,
                        // 'company' => $company
                    ]);
                } else {
                    return response()->json([
                        'message' => 'Please allow the resignation to continue'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'This guard is not present '
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'There was an error creating the policy',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\CreateUserRequest;
use OpenApi\Annotations as OA;




class CompanyController extends Controller
{/**
 * @OA\get(
 *      path="/api/home",
 *      summary="this is my summary and now you are getting into it ",
 *      description="this is the longer description",
 *      @OA\Response(response="200", description="Successful operation"),
 *      @OA\Response(response="401", description="Unauthorized"),
 *      security={{"bearerAuth": {}}}
 * )
 */
    public function index()
    {
        return response()->json([
            'message' => 'how are you '
        ]);
    }


    public function show(string $id)
    {
        // Your implementation
    }

    
    public function store(CreateCompanyRequest $companyRequest, CreateUserRequest $userRequest)
    {
        // Your implementation
    }

    public function update(CreateCompanyRequest $companyrequest, Company $company)
    {
        // Your implementation
    }

    public function destroy(Company $company)
    {
        // Your implementation
    }
}

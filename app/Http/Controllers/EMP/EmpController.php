<?php

namespace App\Http\Controllers\Emp;

use App\Http\Controllers\Controller;
use App\Models\Emp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate exist
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Filter users based on request.
     */
    public function filter(Request $request) {
    }

    public function login(Request $request) {
        $emp = Emp::where('email', $request->email)->first();

        if($emp && Hash::check($request->password, $emp->password)) {
            return response()->json(['message' => "Login successfully!", 'data' => $emp], 200);
        }
        else {
            return response()->json(['message'=> 'Login failed, check your email or password!', 'data'=> $emp], 403);
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();

        if (!$users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        return response()->json(['message' => 'Users retreived successfully!', 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate exist
        $rules = [
            'FIRST_NAME' => 'required|string',
            'LAST_NAME' => 'required|string',
            'EMAIL' => 'required|email|unique:user,email',
            'PASSWORD' => 'required|string',
            'DOB' => 'date|date_format:Y-m-d',
            'GENDER' => 'in:F,M',
            'SDT' => 'numeric|min:6',
            'GPLX' => 'string'
        ];

        $customMessages = [
            'FIRST_NAME.required' => 'The FIRST_NAME field is required.',
            'LAST_NAME.required' => 'The LAST_NAME field is required.',
            'EMAIL.required' => 'The EMAIL field is required.',
            'EMAIL.email' => 'Please provide a valid EMAIL address.',
            'EMAIL.unique' => 'The EMAIL address is already taken.',
            'PASSWORD.required' => 'The PASSWORD field is required.',
            'DOB.date' => 'The date of birth must be a valid date.',
            'DOB.date_format' => 'The date of birth must be in the Y-m-d format.',
            'GENDER.in' => 'The GENDER must be either F or M.',
            'SDT.numeric' => 'The phone number must contain only numeric characters.',
            'SDT.min' => 'The phone number must be at least 6 digits.',
        ];

        // Validate the request data
        $validator = FacadesValidator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        // 
        $data = $request->all();
        $data['USER_ID'] = User::generateUniqueId();
        $data['PASSWORD'] = bcrypt($request->password);
        $user = User::create($data);

        return response()->json(['message' => 'User created successfully!', 'data' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['error' => "User not found"], 404);
        }

        return response()->json(['message' => 'Query successfully!', 'data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => "User not found"], 404);
        }

        $rules = [
            'FIRST_NAME' => 'string',
            'LAST_NAME' => 'string',
            'EMAIL' => 'email|unique:user,email',
            'PASSWORD' => 'string',
            'DOB' => 'date|date_format:Y-m-d',
            'GENDER' => 'in:F,M',
            'SDT' => 'numeric|min:6',
            'GPLX' => 'string'
        ];

        $customMessages = [
            'EMAIL.email' => 'Please provide a valid EMAIL address.',
            'EMAIL.unique' => 'The EMAIL address is already taken.',
            'DOB.date' => 'The date of birth must be a valid date.',
            'DOB.date_format' => 'The date of birth must be in the Y-m-d format.',
            'GENDER.in' => 'The GENDER must be either F or M.',
            'SDT.numeric' => 'The phone number must contain only numeric characters.',
            'SDT.min' => 'The phone number must be at least 6 digits.',
        ];

        // Validate the request data
        $validator = FacadesValidator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        if ($request->has('FIRST_NAME')) {
            $user->FIRST_NAME =  $request->FIRST_NAME;
        }

        if ($request->has('LAST_NAME')) {
            $user->LAST_NAME =  $request->LAST_NAME;
        }

        if ($request->has('DOB')) {
            $user->DOB =  $request->DOB;
        }

        if ($request->has('GENDER')) {
            $user->GENDER =  $request->GENDER;
        }

        if ($request->has('SDT')) {
            $user->SDT =  $request->SDT;
        }

        if ($request->has('GPLX')) {
            $user->GPLX =  $request->GPLX;
        }

        if ($request->has('EMAIL')) {
            $user->EMAIL = $request->EMAIL;
        }

        if ($request->has('PASSWORD')) {
            $user->PASSWORD = bcrypt($request->PASSWORD);
        }

        if (!$user->isDirty()) {
            return response()->json(['error' => 'Your input values are the same in database system, nothing changed', 'data' => $user], 409);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully!', 'data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => "User not found"], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully!', 'data' => $user], 200);
    }
}

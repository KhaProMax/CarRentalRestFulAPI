<?php

namespace App\Http\Controllers\CarOwner;

use App\Http\Controllers\Controller;
use App\Models\CarOwner;
use Illuminate\Http\Request;

class CarOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $carowners = CarOwner::all();

        if ($carowners->isEmpty()) {
            return response()->json(['message' => 'No carowners found'], 404);
        }

        return response()->json(['message' => 'CarOwners retreived successfully!', 'data' => $carowners], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        //
        $carowner = CarOwner::findOrFail($user_id);

        return response()->json(['message' => 'Query successfully!', 'data' => $carowner], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}

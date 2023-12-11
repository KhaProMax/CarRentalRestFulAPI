<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contracts = Contract::all();

        if ($contracts->isEmpty()) {
            return response()->json(['message' => 'No contracts found'], 404);
        }

        return response()->json(['message' => 'Contracts retreived successfully!', 'data' => $contracts], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate exist
        $rules = [
            'USER_ID' => 'required|string',
            'LICENSE_PLATE' => 'required|string',
            'START_DATE' => 'required|date|after_or_equal:now',
            'END_DATE' => 'required|date|after_or_equal:START_DATE',
            'DEPOSIT_STATUS' => 'string|in:Y,N',
            'RETURN_STATUS' => 'string|in:Y,N'
        ];

        $request->validate($rules);

        // 
        $data = $request->all();
        $data['CONTRACT_ID'] = Contract::generateUniqueId();
        // dd($data);

        $contract = Contract::create($data);

        return response()->json(['message' => 'Contract created successfully!', 'data' => $contract], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $contract = Contract::findOrFail($id);

        return response()->json(['message' => 'Query successfully!', 'data' => $contract], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $contract = Contract::findOrFail($id);

        $rules = [
            'START_DATE' => 'date|after_or_equal:now',
            'END_DATE' => 'date|after_or_equal:START_DATE',
            'DEPOSIT_STATUS' => 'string|in:Y,N',
            'RETURN_STATUS' => 'string|in:Y,N'
        ];

        // Validate the request data
        $request->validate($rules);

        if ($request->has('USER_ID')) {
        }

        if ($request->has('LICENSE_PLATE')) {
        }

        if ($request->has('START_DATE')) {
            $contract->START_DATE =  $request->START_DATE;
        }

        if ($request->has('END_DATE')) {
            $contract->END_DATE =  $request->END_DATE;
        }

        if ($request->has('DEPOSIT_STATUS')) {
            $contract->DEPOSIT_STATUS =  $request->DEPOSIT_STATUS;
        }

        if ($request->has('RETURN_STATUS')) {
            $contract->RETURN_STATUS =  $request->RETURN_STATUS;
        }

        $contract->car()->update(['OWNER_ID' => $contract->USER_ID]);

        if (!$contract->isDirty()) {
            return response()->json(['error' => 'Your input values are the same in database system, nothing changed', 'data' => $contract], 409);
        }

        $contract->save();

        return response()->json(['message' => 'Contract updated successfully!', 'data' => $contract], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $contract = Contract::findOrFail($id);

        $contract->delete();

        return response()->json(['message' => 'Contract deleted successfully!', 'data' => $contract], 200);
    }
}

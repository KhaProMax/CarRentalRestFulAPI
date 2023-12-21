<?php

namespace App\Http\Controllers\Bookmark;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Car;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bookmarks = Bookmark::all();

        if ($bookmarks->isEmpty()) {
            return response()->json(['message' => 'No bookmarks found'], 404);
        }

        return response()->json(['message' => 'Bookmarks retreived successfully!', 'data' => $bookmarks], 200);
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
        ];

        $request->validate($rules);

        // 
        $data = $request->all();

        $bookmark = Bookmark::create($data);

        return response()->json(['message' => 'Bookmark created successfully!', 'data' => $bookmark], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        //
        $bookmarks = Bookmark::where('USER_ID', $user_id)->join('car', 'bookmark.LICENSE_PLATE', '=', 'car.LICENSE_PLATE')
        ->select('bookmark.*', 'car.*')->get();
        
        return response()->json(['message' => 'Query successfully!', 'data' => $bookmarks], 200);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $filters = $request->json()->all();

        $bookmarks = Bookmark::query();

        foreach ($filters as $key => $value) {
            $bookmarks->where($key, $value);
        }

        $bookmarks->delete();

        return response()->json(['message' => 'Bookmark deleted successfully!', 'data' => $bookmarks], 200);
    }
}

<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Comments = Comment::all();

        if ($Comments->isEmpty()) {
            return response()->json(['message' => 'No Comments found'], 404);
        }

        return response()->json(['message' => 'Comments retreived successfully!', 'data' => $Comments], 200);
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
            'REVIEW' => 'integer', 
            'COMMENT' => 'string'
        ];

        $request->validate($rules);

        // 
        $data = $request->all();
        $data['COMM_DATE'] = date("Y-m-d");

        $Comment = Comment::create($data);

        return response()->json(['message' => 'Comment created successfully!', 'data' => $Comment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $LICENSE_PLATE)
    {
        //
        $Comment = Comment::where('LICENSE_PLATE', $LICENSE_PLATE)->get();

        return response()->json(['message' => 'Query successfully!', 'data' => $Comment], 200);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        //
        $rules = [
            'USER_ID' => 'required|string',
            'LICENSE_PLATE' => 'required|string',
            'REVIEW' => 'integer', 
            'COMMENT' => 'string'
        ];

        $request->validate($rules);

        $filters = $request->json()->all();

        $findComment = Comment::query();

        foreach ($filters as $key => $value) {
            $findComment->where($key, $value);
        }

        $comment = $findComment->first();

        if ($request->has('REVIEW')) {
            $comment->REVIEW =  $request->REVIEW;
        }

        if ($request->has('COMMENT')) {
            $comment->COMMENT =  $request->COMMENT;
        }

        if (!$comment->isDirty()) {
            return response()->json(['error' => 'Your input values are the same in database system, nothing changed', 'data' => $comment], 409);
        }

        $comment->save();

        return response()->json(['message' => 'Comment updated successfully!', 'data' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $filters = $request->json()->all();

        $Comments = Comment::query();

        foreach ($filters as $key => $value) {
            $Comments->where($key, $value);
        }

        $Comments->delete();

        return response()->json(['message' => 'Comment deleted successfully!', 'data' => $Comments], 200);
    }

    /**
     * Filter users based on request.
     */
    public function filter(Request $request) {
        $filters = $request->json()->all();

        $comments = Comment::query();

        foreach ($filters as $key => $value) {
            $comments->where($key, $value);
        }

        $filteredComments = $comments->get();

        return response()->json(['message' => 'Comments retreived successfully!', 'data' => $filteredComments], 200);
    }
}

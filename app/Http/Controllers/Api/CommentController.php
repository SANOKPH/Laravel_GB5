<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\ListCommentResource;
use App\Http\Resources\Comment\ShowCommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => "This is comment.",
            'data' => ListCommentResource::collection(Comment::list())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::createOrUpdate($request);
        return response()->json([
            'success' => true,
            'message' => "Comment created successfully.",
            'data' => $comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        $comment = new ShowCommentResource($comment);
        return ["success" => true, "data" => $comment];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::createOrUpdate($request, $id);
        return response()->json(["success" => true, "data" => new ShowCommentResource($comment), "Message" => "Comment Was Updated Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Comment was delete successfully'], 200); 
    }
}

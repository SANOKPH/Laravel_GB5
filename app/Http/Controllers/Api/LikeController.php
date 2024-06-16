<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::list(); // Fetch all likes, assuming 'Like' is an Eloquent model

        return response()->json([
            'success' => true,
            'message' => $likes->isEmpty() ? 'No likes found.' : 'Likes retrieved successfully.',
            'data' => $likes
        ], 200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $like = Like::createOrUpdate($request);
        return $like ? response()->json([
            'success' => true,
            'message' => 'like was liked successfully.',
            'data' => $like,
        ], 200) : response()->json([
            'success' => false,
            'message' => 'Something went wrong!.',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
    //   
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
}

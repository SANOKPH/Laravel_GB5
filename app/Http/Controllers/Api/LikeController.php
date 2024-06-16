<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Likes\StoreLikeRequest;
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

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikeRequest $request)
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

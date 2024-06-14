<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserFriendRequest;
use App\Http\Resources\Friends\ListFriendResource;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function requested(Request $request)
    {
        $friend_requesting = Friend::requested($request);
        return response()->json([
            'success' => true,
            'message' => 'Here is a list of your friends you have been requesting.',
            'data' => ListFriendResource::collection($friend_requesting),
            'request_count' => $friend_requesting->count(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFriendRequest $request)
    {
        $friend = Friend::createOrUpdate($request);
        return $friend ? response()->json([
            'success' => true,
            'message' => 'Successfully requested',
            'data' => $friend
        ], 200) : response()->json([
            'success' => false,
            'message' => 'Friend already requested',
        ], 500); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
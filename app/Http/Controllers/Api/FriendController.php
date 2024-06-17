<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserFriendRequest;
use App\Http\Resources\Friends\RequestFromFriendResource;
use App\Http\Resources\Friends\RequestToFriendResource;
use App\Http\Resources\User\ProfileResource;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $friends = Friend::where('user_id', $request->user()->id)->where('is_friend', 1)->get();
        return response()->json([
            'success' => true,
            'message' => 'Here is a list of your friends.',
            'data' => ProfileResource::collection($friends)
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

    public function requestedFromFriend(Request $request) // get friends requested to us
    {
        $friends = Friend::requestedFromFriend($request);
        return response()->json([
            'success' => true,
            'message' => 'Here is a list of people who added friend to you.',
            'data' => RequestFromFriendResource::collection($friends),
            'request_count' => $friends->count(),
        ], 200);
    }

    public function requestToFriend(Request $request) // get friends we are requesting
    {
        $requesting_friends = Friend::requestedToFriend($request);
        return response()->json([
            'success' => true,
            'message' => 'Here is a list of people you are requesting.',
            'data' => RequestToFriendResource::collection($requesting_friends),
            'request_count' => $requesting_friends->count(),
        ], 200);
    }

    public function acceptFriend(Request $request)
    {
        $friend_requested = Friend::where('user_id', $request->friend_id)
            ->where('friend_id', $request->user()->id)
            ->where('is_friend', 0)
            ->get();

        $friend_accept = $friend_requested->count() ? Friend::accept($request) : false;

        return $friend_accept ? response()->json([
            'success' => true,
            'message' => 'Friend accepted successfully.',
            'data' => ProfileResource::collection($friend_accept)
        ], 200) : response()->json([
            'success' => false,
            'message' => 'Friend request not found with id ' . $request->friend_id,
        ], 404);
    }

    public function unfriend(Request $request, $friend_id)
    {
        $is_unfriend = Friend::where('friend_id', $friend_id)->count() ? Friend::unfriend($request, $friend_id) : false;

        return $is_unfriend ? response()->json([
            'success' => true,
            'message' => 'You have unfriend successfully.',
        ], 200) : response()->json([
            'success' => false,
            'message' => 'Friend request not found with id ' . $friend_id,
        ], 404);
    }
}

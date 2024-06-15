<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\SharePostRequest;
use App\Http\Resources\Posts\ListPostResource;
use App\Models\Share;
use Illuminate\Http\Request;

class SharePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $post_shares = Share::list($request->user()->id);
        return response()->json([
            'success' => true,
            'message' => 'list of posts you have shared.',
            'data' => ListPostResource::collection($post_shares)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SharePostRequest $request)
    {
        $share_post = Share::createOrUpdate($request);
        return response()->json([
            'success' => true,
            'message' => 'Post was successfully shared.',
            'data' => $share_post,
        ], 200);
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
    public function destroy(Request $request, string $id)
    {
        $is_deleted = Share::deleteShare($request, $id);
        return $is_deleted ? response()->json([
            'success' => true,
            'message' => 'Successfully deleted post shared.',
        ], 200) : response()->json([
            'success' => false,
            'message' => 'Posts you shared was not found with id: ' .$id
        ], 404);
    }
}

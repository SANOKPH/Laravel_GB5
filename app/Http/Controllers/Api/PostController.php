<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Http\Resources\Posts\ListPostResource;
use App\Http\Resources\User\UserPostResource;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
   /**
    * Display a listing of the resource.
    */
   public function index(Request $request)
   {
      $user_id = $request->user()->id;
      $posts = Post::list($user_id);
      return response()->json([
         'success' => true,
         'message' => 'Here are the list of posts.',
         'data' => ListPostResource::collection($posts),
         'post_count' => $posts->count()
      ], 200);
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(StorePostRequest $request)
   {
      $posts = Post::createOrUpdate($request);
      return response()->json([
         'success' => true,
         'message' => 'Post created successfully.',
         'data' => new ListPostResource($posts),
      ], 200);
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
      $post = Post::find($id);
      return $post ? response()->json([
         'success' => true,
         'message' => 'Successfully updated post.',
         'data' => new ListPostResource($post)
      ], 200) : response()->json([
         'success' => false,
         'message' => 'Post not found with id ' . $id,
      ], 404);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(UpdatePostRequest $request, $id)
   {
      $post = Post::findOrFail($id);
      Media::where('post_id', $post->id)->delete();
      return $post ? response()->json([
         'success' => true,
         'message' => 'Post successfully updated.',
         'data' =>  Post::createOrUpdate($request, $id)
      ], 200) : response()->json([
         'success' => false,
         'message' => 'Post not found with id ' . $id,
      ], 404);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
      $post = Post::find($id);
      $post = $post ? $post->delete() : false;
      return $post ? response()->json([
         'success' => true,
         'message' => 'Post deleted successfully.',
      ],200) : response()->json([
         'success' => false,
         'message' => 'Post not found with id: ' . $id,
      ],404);
   }
}
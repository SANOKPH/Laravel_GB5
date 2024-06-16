<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reactions\StoreReactionRequest;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reaction= Reaction::all();
        return response()->json([
           'success' => true,
           'message' => 'Reaction created successfully.',
            'data' => $reaction
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReactionRequest $request)
    {
        $reaction = Reaction::createOrUpdate($request);
        return response()->json([
           'success' => true,
           'message' => 'Reaction created successfully.',
            'data' => $reaction
        ]);
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

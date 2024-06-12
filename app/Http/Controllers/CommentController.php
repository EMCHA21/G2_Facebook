<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::all();
        $comment = CommentResource::collection($comment);
        return response()->json(['success'=>true,'data'=>$comment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'text'=>request('text'),
            'auth_id'=>request('auth_id'),
            'post_id'=>request('post_id')
        ]);
        return response()->json(['success'=>true,'data'=>$comment]);
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
    public function destroy(Request $request, Comment $post)
    {
        $id = $request->id;
        try {
            $post->deleteComment($id);
            return response()->json(["data" => $post, "message" => "succfully to delete the post"], 200);
        } catch (Exception $erorr) {
            return response()->json(["data" => $post, "message" => "failed to delete this post"], 500);
        }
    }
}

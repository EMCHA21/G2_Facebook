<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comment/list",
     *     summary="get all comments",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $comment = Comment::all();
        $comment = CommentResource::collection($comment);
        return response()->json(['success' => true, 'data' => $comment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Comment::store($request);
        try {
            return response()->json(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => $data]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $posts = Comment::find($id);
            return response(["success" => true, "data" => $posts, "message" => "Post has been show successfully", "status" => 200]);
        } catch (Exception $error) {
            return response(["success" => false, "data" => $posts, "message" => "Post is not find, It was deleted", "error" => $error], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $data = Comment::store($request, $id);
        try {
            return response()->json(['success' => true, 'data' => $data, 'message' => 'Updated successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => $data]);
        }
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

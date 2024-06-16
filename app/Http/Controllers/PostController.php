<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/post/list",
     *     summary="get all posts",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $post = Post::all();
        $post = PostResource::collection($post);
        return response()->json(['success' => true, 'data' => $post]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $imagePath = null;
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads'), $imageName);
            $imagePath =  $imageName;
        }

        $post = Post::create([
            'title' => request('title'),
            'img' => $imagePath,
            'content' => request('content'),
            'auth_id' => request('auth_id'),
            'comment' => request('comment'),
            'tags' => request('tags')
        ]);
        return response()->json(['success' => true, 'data' => new PostResource($post)]);
    }
    public function show(string $id)
    {
        $posts = Post::find($id);
        try {
            $posts = new PostResource($posts);
            return response(["success" => true, "data" => $posts, "message" => "Post has been show successfully", "status" => 200]);
        } catch (\Exception $error) {
            return response(["data" => $posts, "message" => "Post is not find, It was deleted", "error" => $error], 500);
        }
    }

    public function update(Request $request, String $id)
    {
        $data = Post::store($request, $id);
        try {
            return response()->json(["data" => $data, "message" => "update successfully the post"], 200);
        } catch (Exception $error) {
            return response()->json(["data" => $data, "message" => "failed to update this post"], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Post::destroy($id);
            return response()->json(["success" => true, "message" => "succfully to delete the post"], 200);
        } catch (Exception $erorr) {
            return response()->json(["success" => false, "message" => "failed to delete this post"], 500);
        }
    }
}

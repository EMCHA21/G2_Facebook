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
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        $post = PostResource::collection($post);
        return response()->json(['success' => true, 'data' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'tags' => request('tags')
        ]);
        return response()->json(['success' => true, 'data' => $post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, string $id)
    {
        try {
            $posts = Post::find($id);
            return response(["data" => $posts, "message" => "Post has been show successfully", "status" => 200]);
        } catch (Exception $error) {
            return response(["data" => $posts, "message" => "Post is not find, It was deleted", "error" => $error], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $title = $request->title;
        $content = $request->content;
        $auth_id = $request->auth_id;
        $tags = $request->tags;
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $img = time() . '.' . $image->extension();
            $image->move(public_path('upload'), $img);
        }
        $post = Post::find($request->id);
        try {
            $post->updatePost($id, $title, $img, $content, $auth_id, $tags);
            return response()->json(["data" => $post, "message" => "update successfully the post"], 200);
        } catch (Exception $error) {
            return response()->json(["data" => $post, "message" => "failed to update this post"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $id = $request->id;
        try {
            $post->deletePost($id);
            return response()->json(["data" => $post, "message" => "succfully to delete the post"], 200);
        } catch (Exception $erorr) {
            return response()->json(["data" => $post, "message" => "failed to delete this post"], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
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
        return response()->json(['success'=>true,'data'=>$post]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'title'=>request('title'),
            'content'=>request('content'),
            'auth_id'=>request('auth_id'),
            'tags'=>request('tags')
        ]);
        return response()->json(['success'=>true,'data'=>$post]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, string $id)
    {
        try{
            $posts = Post::find($id);
            return response(["data"=>$posts,"message"=>"Post has been show successfully","status"=>200]);
        }catch(Exception $error){
            return response(["data"=>$posts,"message"=>"Post is not find, It was deleted","error"=>$error],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $id = $request->id;
        $title = $request->title;
        $content = $request->content;
        $auth_id = $request->auth_id;
        $tags = $request->tags;
        
        $post = Post::where('id',$id)->first();
        try{
            $post-> updatePost($id, $title, $content,$auth_id,$tags);
            return response()->json(["data" => $post,"message"=>"update successfully the post"],200);
        }catch(Exception $error){
            return response()->json(["data" => $post,"message"=>"failed to update this post"],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Post $post)
    {
        $id=$request->id;
        try{
            $post->deletePost($id);
            return response()->json(["data" => $post,"message"=>"succfully to delete the post"],200);
        }catch(Exception $erorr){
            return response()->json(["data" => $post,"message"=>"failed to delete this post"],500);
        }
    }
}

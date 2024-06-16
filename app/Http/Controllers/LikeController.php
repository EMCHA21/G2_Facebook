<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * add like or un like.
     */
    public function addLike(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
        ]);
        $like = Like::where('post_id', $request->post_id)->where('user_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            return response("Unlike");
        }
        Like::create([
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
        ]);
        return response("Like");
    }
    /**
     * @OA\Get(
     *     path="/api/like/list",
     *     summary="get all like",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $likes = Like::all();
        return response()->json(['likes' => $likes]);
    }
}

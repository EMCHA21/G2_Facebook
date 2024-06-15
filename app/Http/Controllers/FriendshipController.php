<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    //add friend
    public function addFried(Request $request)
    {
        $request->validate([
            'friend_id' => 'required',
        ]);
        $user_id = Auth::id();
        // Check if the friendship request already exists
        $existingRequest = Friend::where('user_id', $user_id)
            ->where('friend_id', $request->friend_id)
            ->first();

        if ($existingRequest) {
            return response()->json(['error' => 'Friend request already sent.'], 400);
        }
        if ($user_id == $request->friend_id) {
            return response()->json(['error' => 'Can not add yourself'], 400);
        }
        // Create a new friend request
        Friend::create([
            'user_id' => $user_id,
            'friend_id' => $request->friend_id,
            'confirm' => false,
        ]);

        return response()->json(['message' => 'Friend request sent successfully.']);
    }
    //list of friend requests
    public function list_friend_accepted()
    {
        $friends = Friend::all();
        $list_friend = collect();
        foreach ($friends as $friend) {
            if ($friend->confirm == true) {
                $list_friend->push($friend);
            }
        }

        return response()->json(['friends' => $list_friend]);
    }
    // list friends that unaccept
    public function list_friend_unaccepted()
    {
        $friends = Friend::all();
        $list_friend = collect();
        foreach ($friends as $friend) {
            if ($friend->confirm == false) {
                $list_friend->push($friend);
            }
        }

        return response()->json(['friends' => $list_friend]);
    }

    //confirm friend
    public function confirmFriend(Request $request)
    {
        $request->validate([
            'friend_id' => 'required',
        ]);

        $user_id = Auth::id();

        // Find the friend request
        $friendRequest = Friend::where('user_id', $request->friend_id)
            ->where('friend_id', $user_id)
            ->where('confirm', false)
            ->first();

        if (!$friendRequest) {
            return response()->json(['error' => 'Friend request not found or already confirmed.'], 404);
        }

        // Confirm the friend request
        $friendRequest->confirm = true;
        $friendRequest->save();

        return response()->json(['message' => 'Friend request confirmed successfully.']);
    }

    // unacceptable friend request
    public function unaccepted($id)
    {
        $friend = Friend::destroy($id);
        return response()->json(['data' => $friend, 'message' => 'Friend unconfirmed successfully.']);
    }

    // unfriend friend
    public function unfriend($id)
    {
        $friend = Friend::destroy($id);
        return response()->json(['data' => $friend, 'message' => 'Friend unfriend successfully.']);
    }
}

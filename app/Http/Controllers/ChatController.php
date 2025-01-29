<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Message;

class ChatController extends Controller
{
    public function index($friendId)
    {
        $friend = User::findOrFail($friendId);

        $messages = Message::where(function ($query) use ($friendId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $friendId);
        })->orWhere(function ($query) use ($friendId) {
            $query->where('sender_id', $friendId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        Message::where('receiver_id', auth()->id())
              ->where('sender_id', $friendId)
              ->where('seen', 0)
              ->update(['seen' => 1]);

        // Check if the friend has logged in at all
        $isFriendLoggedIn = $friend->last_logged_in_at !== null;

        // Pass the necessary data to the view
        return view('chat.index', compact('friend', 'messages', 'isFriendLoggedIn', 'friendId'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Check if the sender and receiver are friends (friend request is accepted)
        $friendship = \DB::table('friend_requests')
            ->where(function ($query) use ($request) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $request->receiver_id)
                      ->where('status', 'accepted'); // Sender -> Receiver (Accepted)
            })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->receiver_id)
                      ->where('receiver_id', auth()->id())
                      ->where('status', 'accepted'); // Receiver -> Sender (Accepted)
            })
            ->exists();

        if (!$friendship) {
            // Return an error or message indicating that they are not friends
            return back()->with('error', 'You can only send messages to friends.');
        }

        // If they are friends, proceed to send the message
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully.');
    }
}
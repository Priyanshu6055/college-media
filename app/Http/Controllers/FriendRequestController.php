<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\User;

class FriendRequestController extends Controller
{


    public function pendingRequests()
    {
        // Fetch pending requests where the user is the receiver
        $pendingRequests = FriendRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        return view('student.pending_requests', compact('pendingRequests'));
    }

    /**
     * Send a friend request to another user.
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        // Check if the sender is trying to send a request to themselves
        if ($request->receiver_id == auth()->id()) {
            return back()->with('error', 'You cannot send a friend request to yourself.');
        }

        // Check if a request already exists between the two users
        $existingRequest = FriendRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $request->receiver_id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You have already sent a friend request to this user.');
        }

        // Create a new friend request
        FriendRequest::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    /**
     * Accept a friend request.
     */
    public function accept(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:friend_requests,id',
        ]);

        $friendRequest = FriendRequest::findOrFail($request->request_id);

        // Check if the authenticated user is the receiver of the request
        if ($friendRequest->receiver_id != auth()->id()) {
            return back()->with('error', 'You are not authorized to accept this friend request.');
        }

        // Accept the friend request
        $friendRequest->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted!');
    }

    /**
     * Reject a friend request.
     */
    public function reject(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:friend_requests,id',
        ]);

        $friendRequest = FriendRequest::findOrFail($request->request_id);

        // Check if the authenticated user is the receiver of the request
        if ($friendRequest->receiver_id != auth()->id()) {
            return back()->with('error', 'You are not authorized to reject this friend request.');
        }

        // Reject the friend request
        $friendRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Friend request rejected!');
    }
}

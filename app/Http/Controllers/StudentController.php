<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display the student dashboard.
     */


    // 2. Friends
    public function friends()
    {
        $userId = auth()->id(); // Get the logged-in user ID

        // Fetch the friends of the logged-in user (those with 'accepted' status)
        $friends = User::whereHas('friends', function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->where('status', 'accepted');
        })->get();

        // Return the friends to the view
        return view('student.friends', compact('friends'));
    }




    public function mutualFriends()
    {
        $userId = auth()->id(); // Get the logged-in user ID

        // Get the mutual friends (friends of friends) using the model method
        $mutualFriends = User::find($userId)->mutualFriends();

        return view('student.mutual-friends', compact('mutualFriends'));
    }






    public function showAllStudents()
    {
        $students = User::where('role', 'student')
            ->where('id', '!=', auth()->user()->id) // Exclude the logged-in student
            ->get();

        return view('student.students', compact('students'));
    }


    public function index()
    {
        return view('student.dashboard'); // Student-specific dashboard view
    }

    /**
     * Display a listing of all students (accessible by teachers and students).
     */
    public function list()
    {
        $students = User::where('id', '!=', auth()->id()) // Exclude the current user
            ->where('role', 'student')
            ->get(); // Fetch all other students
        return view('student.index', compact('students')); // Common view for listing students
    }

    /**
     * Show the details of a specific student (accessible by teachers).
     * The teacher can edit student data on this page.
     */
    public function show($id)
    {
        $student = User::where('role', 'student')->findOrFail($id); // Fetch student by ID
        return view('teacher.students.edit', compact('student')); // Render edit view
    }

    /**
     * Update a specific student's data (accessible by teachers).
     */
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        // Validate the input data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $student->id],
        ]);

        // Update the student's information
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redirect back to the students listing page with a success message
        return redirect()->route('teacher.dashboard')->with('success', 'Student data updated successfully.');
    }

    /**
     * Delete a specific student (accessible by teachers).
     */
    public function destroy($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();

        // Redirect back to the students listing page with a success message
        return redirect()->route('teacher.dashboard')->with('success', 'Student deleted successfully.');
    }

    /**
     * Send a friend request to another student.
     */
    public function sendFriendRequest($id)
    {
        $recipient = User::where('id', $id)->where('role', 'student')->firstOrFail();

        // Logic to send a friend request
        $recipient->friendRequests()->create(['sender_id' => Auth::id()]);

        return redirect()->back()->with('success', 'Friend request sent successfully.');
    }

    /**
     * Accept a friend request.
     */
    public function acceptFriendRequest($id)
    {
        $sender = User::where('id', $id)->where('role', 'student')->firstOrFail();

        // Logic to accept the friend request
        Auth::user()->friends()->attach($sender->id);

        // Delete the friend request
        Auth::user()->receivedFriendRequests()->where('sender_id', $sender->id)->delete();

        return redirect()->back()->with('success', 'Friend request accepted.');
    }

    /**
     * Reject a friend request.
     */
    public function rejectFriendRequest($id)
    {
        $sender = User::where('id', $id)->where('role', 'student')->firstOrFail();

        // Logic to reject the friend request
        Auth::user()->receivedFriendRequests()->where('sender_id', $sender->id)->delete();

        return redirect()->back()->with('success', 'Friend request rejected.');
    }

    /**
     * Display chat with a specific friend.
     */
    public function chat($friendId)
    {
        $friend = User::where('id', $friendId)->where('role', 'student')->firstOrFail();

        // Fetch chat messages
        $messages = Auth::user()->chats()->where('friend_id', $friendId)->get();

        return view('students.chat', compact('friend', 'messages'));
    }

    /**
     * Send a chat message to a specific friend.
     */
    public function sendMessage(Request $request, $friendId)
    {
        $friend = User::where('id', $friendId)->where('role', 'student')->firstOrFail();

        // Validate the message
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Logic to send the message
        Auth::user()->chats()->create([
            'friend_id' => $friendId,
            'message' => $request->message,
        ]);

        return redirect()->route('students.chat', $friendId)->with('success', 'Message sent.');
    }
}

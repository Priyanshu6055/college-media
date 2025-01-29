<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper; // Add this line if you're using a helper file

class PhotoController extends Controller
{
    /**
     * Store a new photo.
     */
    public function store(Request $request)
    {
        // Validate the uploaded photo
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'privacy' => 'required|in:all,friends',
        ]);

        // Upload the image temporarily
        $image = $request->file('photo');
        $tempPath = $image->store('temp', 'public');  // Temporarily store the image

        // Compress the uploaded image
        $compressedPath = storage_path('app/public/temp/compressed_' . basename($tempPath));
        ImageHelper::compressImage(storage_path('app/public/' . $tempPath), $compressedPath, 75); // 75 is the quality level

        // Move the compressed image to the final destination
        $finalPath = 'photos/' . basename($tempPath);
        \Storage::move($tempPath, $finalPath);  // Move the original image to the final path
        \Storage::move('public/temp/compressed_' . basename($tempPath), 'public/' . $finalPath);  // Move the compressed image

        // Create a new photo record
        Photo::create([
            'user_id' => Auth::id(),
            'file_path' => $finalPath,  // Save the path to the compressed image
            'caption' => $request->caption,
            'privacy' => $request->privacy,
        ]);

        return redirect()->back()->with('success', 'Photo uploaded and compressed successfully!');
    }

    public function index()
    {
        $user = Auth::user();

        $photos = Photo::with('user')
            ->where('user_id', $user->id)
            ->whereIn('privacy', ['all', 'friends'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('photos.index', compact('photos'));
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Fetch all public photos and photos visible to the logged-in user (based on privacy settings)
        $photos = Photo::with('user')
            ->where('privacy', 'all') // Show public photos
            ->orWhere(function ($query) use ($user) {
                // Show friends' "friends-only" photos if the logged-in user is friends with the uploader
                $query->where('privacy', 'friends')
                    ->whereIn('photos.user_id', $user->friends()->pluck('users.id')); // Specify 'users.id' explicitly
            })
            ->orWhere('user_id', $user->id) // Show the logged-in user's photos (private or public)
            ->latest()
            ->get();

        return view('dashboard', compact('photos'));
    }
}

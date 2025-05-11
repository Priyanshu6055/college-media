<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Store a new photo.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         // Validate the uploaded photo
    //         $validated = $request->validate([
    //             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //             'caption' => 'nullable|string|max:255',
    //             'privacy' => 'required|in:all,friends',
    //         ]);

    //         // Upload the image temporarily
    //         $image = $request->file('photo');
    //         $tempPath = $image->store('temp', 'public');

    //         // Compress the uploaded image
    //         $compressedFilename = 'compressed_' . basename($tempPath);
    //         $compressedPath = storage_path('app/public/temp/' . $compressedFilename);
    //         $originalPath = storage_path('app/public/' . $tempPath);

    //         if (!ImageHelper::compressImage($originalPath, $compressedPath, 75)) {
    //             throw new \Exception("Image compression failed.");
    //         }

    //         // Final destination path
    //         $finalPath = 'photos/' . basename($tempPath);

    //         // Move the compressed image
    //         if (!Storage::disk('public')->move('temp/' . $compressedFilename, $finalPath)) {
    //             throw new \Exception("Failed to move compressed image to final location.");
    //         }

    //         // Save photo record
    //         Photo::create([
    //             'user_id' => Auth::id(),
    //             'file_path' => $finalPath,
    //             'caption' => $validated['caption'] ?? null,
    //             'privacy' => $validated['privacy'],
    //         ]);

    //         return redirect()->back()->with('success', 'Photo uploaded and compressed successfully!');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return redirect()->back()
    //             ->withErrors($e->validator)
    //             ->withInput();
    //     } catch (\Exception $e) {
    //         Log::error('Photo upload error: ' . $e->getMessage());

    //         return redirect()->back()
    //             ->with('error', 'An error occurred while uploading the photo. Please try again.')
    //             ->withInput();
    //     }
    // }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'privacy' => 'required|in:all,friends',
        ]);

        $image = $request->file('photo');

        // Store temporarily
        $tempPath = $image->store('temp', 'public');

        $originalPath = storage_path('app/public/' . $tempPath);
        $compressedFilename = 'compressed_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $compressedPath = storage_path('app/public/temp/' . $compressedFilename);

        if (!ImageHelper::compressImage($originalPath, $compressedPath, 75)) {
            throw new \Exception("Image compression failed.");
        }

        // Final destination path
        $finalPath = 'photos/' . $compressedFilename;

        // Move compressed image to final location
        if (!Storage::disk('public')->move('temp/' . $compressedFilename, $finalPath)) {
            throw new \Exception("Failed to move compressed image to final location.");
        }

        // Save record in database
        Photo::create([
            'user_id' => Auth::id(),
            'file_path' => $finalPath,
            'caption' => $validated['caption'] ?? null,
            'privacy' => $validated['privacy'],
        ]);

        return redirect()->back()->with('success', 'Photo uploaded successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->validator)
            ->withInput();
    } catch (\Exception $e) {
        \Log::error('Photo upload error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}


    /**
     * Show all photos of the authenticated user.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            $photos = Photo::with('user')
                ->where('user_id', $user->id)
                ->whereIn('privacy', ['all', 'friends'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('photos.index', compact('photos'));
        } catch (\Exception $e) {
            Log::error('Error fetching user photos: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to load your photos.');
        }
    }

    /**
     * Show the dashboard with visible photos.
     */
    public function dashboard()
    {
        try {
            $user = Auth::user();

            $photos = Photo::with('user')
                ->where('privacy', 'all')
                ->orWhere(function ($query) use ($user) {
                    $query->where('privacy', 'friends')
                        ->whereIn('photos.user_id', $user->friends()->pluck('users.id'));
                })
                ->orWhere('user_id', $user->id)
                ->latest()
                ->get();

            return view('dashboard', compact('photos'));
        } catch (\Exception $e) {
            Log::error('Error loading dashboard photos: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to load dashboard photos.');
        }
    }
}

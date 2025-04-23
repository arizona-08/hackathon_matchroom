<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{

    public function getProfilePic(Request $request){
        $user = $request->user();
        if ($user->photo_path) {
            return response()->json([
                'url' => Storage::url($user->photo_path),
            ], 200);
        }

        return response()->json(['error' => 'No image found'], 404);
    }

    public function storeProfilePic(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');

            $user->photo_path = $path;
            $user->save();

            return response()->json([
                'message' => 'Image uploaded successfully',
                'path' => $path,
                'url' => Storage::url($path),
            ], 200);
        }

        return response()->json(['error' => 'Unable to upload image'], 422);
    }
}

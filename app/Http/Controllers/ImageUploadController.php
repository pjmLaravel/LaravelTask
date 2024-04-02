<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{



    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName, 'public');

            $url = asset('storage/uploads/' . $fileName); // 파일 URL 생성

            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'File not found'], 404);
    }

//     public function upload(Request $request)
// {
//     $request->validate([
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//     ]);

//     $imagePath = $request->file('image')->store('uploads', 'public');
//     $imageName = pathinfo($imagePath, PATHINFO_FILENAME);

//     return response()->json(['url' => asset('storage/' . $imagePath)]);
// }
}

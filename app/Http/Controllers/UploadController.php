<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadFile(Request $request) {
        $request->file->store('public');
        
    }
}

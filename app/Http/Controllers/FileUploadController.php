<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function index()
    {
        $uploads = FileUpload::latest()->get();
        return view('file_upload.index', compact('uploads'));
    }

    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Max 2MB
        ]);

        try {
            // Store file first
            $path = $request->file('file')->store('uploads', 'public');

            // Create record with file_path and status together
            FileUpload::create([
                'file_path' => $path,
                'status' => 'uploaded',
            ]);

            return back()->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            // Optional: log or create failed record if you want
            // FileUpload::create([
            //     'file_path' => '',
            //     'status' => 'failed',
            // ]);
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
}

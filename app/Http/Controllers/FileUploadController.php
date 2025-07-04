<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function index()
    {
        $uploads = FileUpload::with('media')->latest()->get();
        return view('file_upload.index', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:2048',
            'disk' => 'required|in:public,local',
        ]);

        try {
            $disk = $request->disk;

            // Create DB record first
            $upload = FileUpload::create([
                'disk' => $disk,
                'status' => 'pending',
            ]);

            // Attach media
            $upload->addMedia($request->file('file'))
                ->toMediaCollection('files', $disk);

            // Update status
            $upload->update(['status' => 'uploaded']);

            return back()->with('success', 'File uploaded!');
        } catch (\Exception $e) {
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function destroy(FileUpload $fileUpload)
    {
        try {
            $fileUpload->clearMediaCollection('files');
            $fileUpload->delete();

            return back()->with('success', 'File deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}

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
        'file' => 'required|file|max:2048',
        'disk' => 'required|in:public,local',
    ]);

    try {
        $userChosenDisk = $request->disk;       // keep what user selected (public or local)
        $uploadedFile = $request->file('file');

        // Always store media files & thumbnails on 'public' disk so they are visible in browser
        $mediaDisk = 'public';

        // Create DB entry, keep user-selected disk in DB
        $fileUpload = FileUpload::create([
            'disk' => $userChosenDisk,
            'status' => 'uploaded',
            'file_path' => '', // will fill below
        ]);

        // Add media to Spatie on 'public' disk, thumbnails will be accessible
        $media = $fileUpload->addMedia($uploadedFile)
                            ->toMediaCollection('uploads', $mediaDisk);

        // Save actual file name in DB
        $fileUpload->update([
            'file_path' => $media ? $media->file_name : '',
        ]);

        return back()->with('success', 'File uploaded and thumbnail generated!');
    } catch (\Exception $e) {
        return back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}


    public function destroy(FileUpload $fileUpload)
    {
        try {
            // Remove from Spatie media library
            $fileUpload->clearMediaCollection('uploads');

            // Remove DB entry
            $fileUpload->delete();

            return back()->with('success', 'File and thumbnail deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}

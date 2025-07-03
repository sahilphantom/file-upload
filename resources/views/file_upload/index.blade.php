@extends('layouts.app') {{-- Use your layout --}}
@vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Include your CSS and JS --}}
@section('content')
<div class="max-w-xl mx-auto bg-gray-800 bg-opacity-80 backdrop-blur-md rounded-2xl shadow-xl p-6 space-y-4">

    <h2 class="text-2xl font-semibold text-center text-white">📁 File Upload</h2>

    @if(session('success'))
        <div class="bg-green-500 bg-opacity-20 text-green-300 p-2 rounded text-sm">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-500 bg-opacity-20 text-red-300 p-2 rounded text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('file-upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <input type="file" name="file" required 
            class="block w-full rounded-lg border border-gray-600 bg-gray-700 text-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        @error('file')
            <div class="text-red-400 text-sm">{{ $message }}</div>
        @enderror

        <button type="submit" 
            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold py-2 rounded-lg shadow-md transition duration-200">
            Upload
        </button>
    </form>

    <div>
        <h3 class="font-semibold text-gray-300 mb-2">Upload Status</h3>
        <ul class="list-disc pl-4 space-y-1 text-gray-300 text-sm">
            @forelse($uploads as $upload)
                <li>
                    <span class="font-mono break-all">{{ $upload->file_path }}</span> -
                    <span class="{{ $upload->status == 'uploaded' ? 'text-green-400' : ($upload->status == 'failed' ? 'text-red-400' : 'text-yellow-400') }}">
                        {{ ucfirst($upload->status) }}
                    </span>
                </li>
            @empty
                <li class="text-gray-500">No uploads yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

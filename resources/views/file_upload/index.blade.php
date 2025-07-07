@extends('layouts.app')

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
            class="block w-full rounded-lg border border-gray-600 bg-gray-700 text-gray-200 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <select name="disk" required
            class="block w-full rounded-lg border border-gray-600 bg-gray-700 text-gray-200 p-2">
            <option value="public">Public Disk</option>
            <option value="local">Local Disk</option>
        </select>

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
                @php
                    $url = $upload->disk === 'public' 
                        ? Storage::disk('public')->url($upload->file_path)
                        : '#'; // local disk is private; change if you serve via route
                @endphp
                <li>
                    <a href="{{ $url }}" target="_blank" class="text-blue-400 underline">
                        {{ basename($upload->file_path) }}
                    </a> -
                    <span class="{{ $upload->status == 'Uploaded' ? 'text-green-400' : 'text-red-400' }}">
                        {{ $upload->status }}
                    </span>
                    <form action="{{ route('file-upload.destroy', $upload) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-400 hover:underline ml-2">Delete</button>
                    </form>
                </li>
            @empty
                <li class="text-gray-500">No uploads yet.</li>
            @endforelse
        </ul>
    </div>

    <div>
        <h3 class="font-semibold text-gray-300 mb-2">📷 Thumbnails</h3>
        <div class="grid grid-cols-2 gap-3">
            @foreach($uploads as $upload)
                @php
                    $media = $upload->getFirstMedia('uploads');
                @endphp
                @if ($media)
                    <img src="{{ $media->getUrl('thumb') }}" alt="Thumbnail" class="rounded shadow">
                @endif
            @endforeach
        </div>
    </div>

</div>
@endsection

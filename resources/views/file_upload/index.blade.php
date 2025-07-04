@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">File Upload</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-2">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-2">{{ session('error') }}</div>
    @endif

    <form action="{{ route('file-upload.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <input type="file" name="file" required class="border p-2 rounded w-full mb-2">
        <select name="disk" class="border p-2 rounded w-full mb-2">
            <option value="public">Public</option>
            <option value="local">Local</option>
        </select>
        @error('file')
            <div class="text-red-600">{{ $message }}</div>
        @enderror
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>

    <h3 class="font-semibold mb-2">Uploaded Files</h3>
    <ul class="space-y-2">
        @forelse($uploads as $upload)
            @php
                $media = $upload->getFirstMedia('files');
            @endphp
            <li class="flex items-center space-x-3">
                @if($media && str_starts_with($media->mime_type, 'image/'))
                    <img src="{{ $media->getUrl('thumb') }}" class="w-12 h-12 rounded object-cover">
                @else
                    <span class="w-12 h-12 flex items-center justify-center bg-gray-200 text-gray-600 rounded">
                        📄
                    </span>
                @endif
                <a href="{{ $media->getUrl() }}" target="_blank" class="text-blue-500 underline">
                    {{ $media->file_name }}
                </a>
                <span class="ml-auto {{ $upload->status == 'Uploaded' ? 'text-green-500' : 'text-red-500' }}">
                    {{ $upload->status }}
                </span>
                <form action="{{ route('file-upload.destroy', $upload) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:underline ml-2">Delete</button>
                </form>
            </li>
        @empty
            <li class="text-gray-500">No uploads yet.</li>
        @endforelse
    </ul>
</div>
@endsection

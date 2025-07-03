<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- optional --}}
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100 min-h-screen flex flex-col">

    <header class="bg-gradient-to-r from-purple-700 to-indigo-700 shadow-lg p-6">
        <h1 class="text-3xl font-bold tracking-wide text-white text-center">My Laravel App</h1>
    </header>

    <main class="flex-1 container mx-auto px-4 py-8">
        <div class="bg-gray-800 bg-opacity-70 backdrop-blur-md rounded-2xl shadow-xl p-8 max-w-3xl mx-auto">
            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-700 py-4 text-center text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} My App</p>
    </footer>

</body>
</html>

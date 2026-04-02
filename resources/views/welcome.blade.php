<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">
        <div class="max-w-2xl text-center">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4">Online Library Management</h1>
            <p class="text-lg text-gray-600 mb-8">Securely manage books, members, and library operations.</p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 bg-white text-blue-600 font-medium rounded border border-blue-600 hover:bg-blue-50 transition">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</body>
</html>

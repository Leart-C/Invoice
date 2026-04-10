<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100">

    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <span class="font-bold text-gray-800">Invoice Tracker</span>
        <div class="flex items-center gap-4">
            <img src="{{ auth()->user()->avatar }}" class="w-8 h-8 rounded-full">
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    
    <main class="p-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
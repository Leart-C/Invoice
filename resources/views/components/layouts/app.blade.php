<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body style="margin:0; padding:0; background:#f9fafb; font-family: system-ui, sans-serif;">

    <x-layouts.topbar />

    <div style="display:flex; height:calc(100vh - 57px);">

        <x-layouts.sidebar />

        <main style="flex:1; overflow-y:auto; padding:32px;">
            {{ $slot }}
        </main>

    </div>

    @livewireScripts
</body>
</html>
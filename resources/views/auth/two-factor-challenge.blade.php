<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Challenge — Invoice Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-10 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">Two-Factor Verification</h1>
        <p class="text-gray-500 text-sm mb-6 text-center">
            Enter the authentication code from your authenticator app or use a recovery code.
        </p>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/two-factor-challenge') }}" class="space-y-4">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Authentication Code</label>
                <input
                    id="code"
                    name="code"
                    type="text"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="xxx xxx"
                >
            </div>
            <div>
                <p class="block text-sm font-medium text-gray-700 mb-1">or</p>
            </div>

            <div>
                <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-1">Recovery Code</label>
                <input
                    id="recovery_code"
                    name="recovery_code"
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter a recovery code instead"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-600 text-white font-medium py-3 hover:bg-blue-700 transition"
            >
                Verify Login
            </button>
        </form>
    </div>
</body>
</html>

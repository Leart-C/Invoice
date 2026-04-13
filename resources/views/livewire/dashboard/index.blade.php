<div>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <p class="text-green-700 font-medium">Google OAuth is working.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-md">
        <div class="flex items-center gap-4">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" class="rounded-full" style="width:48px;height:48px">
            @else
                <div style="width:48px;height:48px;border-radius:50%"
                     class="bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <p class="font-bold text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full capitalize">
                    {{ auth()->user()->role }}
                </span>
            </div>
        </div>
    </div>
</div>
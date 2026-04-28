<header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6 shadow-sm">
    <a
        href="{{ route('dashboard') }}"
        class="text-sm font-semibold tracking-tight text-slate-900 transition hover:text-blue-600"
    >
        Invoice Tracker
    </a>

    <div class="flex items-center gap-3">
        @if(auth()->user()->avatar)
            <img
                src="{{ auth()->user()->avatar }}"
                alt="{{ auth()->user()->name }}"
                class="h-9 w-9 rounded-full object-cover ring-2 ring-slate-100"
            >
        @else
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 ring-2 ring-blue-50">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif

        <div class="hidden text-right sm:block">
            <p class="text-sm font-medium text-slate-800">
                {{ auth()->user()->name }}
            </p>
            <p class="text-xs text-slate-500">
                Signed in
            </p>
        </div>

        <span class="inline-flex items-center rounded-full bg-violet-100 px-3 py-1 text-xs font-semibold capitalize tracking-wide text-violet-700">
            {{ auth()->user()->role }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button
                type="submit"
                class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-100 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-200"
            >
                Logout
            </button>
        </form>
    </div>
</header>

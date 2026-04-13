<header style="height:57px; background:white; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; padding:0 24px; position:sticky; top:0; z-index:10;">

    <a href="{{ route('dashboard') }}"
       style="font-weight:700; font-size:15px; color:#111827; text-decoration:none;">
        Invoice Tracker
    </a>
    
    <div style="display:flex; align-items:center; gap:12px;">

        @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}"
                 style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
        @else
            <div style="width:32px; height:32px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:#2563eb;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif

        <span style="font-size:14px; color:#374151; font-weight:500;">
            {{ auth()->user()->name }}
        </span>

        <span style="font-size:12px; background:#f3e8ff; color:#7e22ce; padding:2px 10px; border-radius:99px; font-weight:500; text-transform:capitalize;">
            {{ auth()->user()->role }}
        </span>

        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit"
                    style="font-size:13px; color:#ef4444; background:none; border:none; cursor:pointer; font-family:inherit;">
                Logout
            </button>
        </form>

    </div>
</header>
<aside style="width:220px; min-width:220px; height:100%; background:white; border-right:1px solid #e5e7eb; display:flex; flex-direction:column; padding:16px 12px;">

    <nav style="display:flex; flex-direction:column; gap:4px;">

        @foreach($navItems as $item)

            @if($item['active'])

                @php $isActive = request()->routeIs($item['match']); @endphp

                <a href="{{ route($item['route']) }}"
                   style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none;
                   {{ $isActive ? 'background:#2563eb; color:white;' : 'color:#4b5563;' }}">
                    <x-icons.nav :name="$item['icon']" />
                    {{ $item['label'] }}
                </a>

            @else

                <a href="#"
                   style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; font-size:14px; font-weight:500; text-decoration:none; color:#9ca3af; cursor:not-allowed;">
                    <x-icons.nav :name="$item['icon']" />
                    {{ $item['label'] }}
                    <span style="margin-left:auto; font-size:11px; background:#f3f4f6; color:#9ca3af; padding:2px 8px; border-radius:99px;">Soon</span>
                </a>

            @endif

            @if(!isset($item['admin_only']) || auth()->user()->role === 'admin')
                {{-- render the link --}}
            @endif

        @endforeach

    </nav>

</aside>
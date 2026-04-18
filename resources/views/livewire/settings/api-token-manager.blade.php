<div class="space-y-8">
    <section class="rounded-3xl border border-slate-200 bg-white/95 p-7 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Security</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">API Tokens</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Create personal access tokens for mobile apps, frontend clients, Postman, or external integrations.
                Tokens are shown only once after creation and can be revoked at any time.
            </p>
        </div>
    </section>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/90 px-5 py-4 text-sm text-emerald-800 shadow-sm transition-all duration-300">
            {{ session('success') }}
        </div>
    @endif

    <section class="rounded-3xl border border-slate-200 bg-white/95 p-7 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-slate-900">Create A New Token</h2>
            <p class="mt-1 text-sm text-slate-500">
                Use a clear name so you know where the token is being used later.
            </p>
        </div>

        <form wire:submit="createToken" class="space-y-5">
            <div>
                <label for="tokenName" class="block text-sm font-medium text-slate-700">Token Name</label>
                <input
                    wire:model="tokenName"
                    id="tokenName"
                    type="text"
                    placeholder="React Dashboard, Mobile App, Postman"
                    class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-all duration-300 placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 hover:border-slate-400 hover:shadow-md"
                >
                <p class="mt-2 text-xs text-slate-500">
                    Pick something descriptive so it is easy to recognize and revoke later.
                </p>
                @error('tokenName')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="createToken"
                    class="inline-flex items-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-100 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="createToken">Create Token</span>
                    <span wire:loading wire:target="createToken">Creating...</span>
                </button>
            </div>
        </form>

        @if ($plainTextToken)
            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50/90 p-5 shadow-sm transition-all duration-300">
                <h3 class="text-sm font-semibold text-amber-900">Token Created</h3>
                <p class="mt-1 text-sm text-amber-800">
                    Copy this token now. For security reasons, it will not be shown again.
                </p>

                <div class="mt-4 rounded-2xl border border-amber-300 bg-white px-4 py-3 shadow-inner">
                    <code class="block break-all text-sm text-slate-800">{{ $plainTextToken }}</code>
                </div>
            </div>
        @endif
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white/95 p-7 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-5">
            <h2 class="text-xl font-semibold text-slate-900">Existing Tokens</h2>
            <p class="mt-1 text-sm text-slate-500">
                Revoke tokens that are no longer needed or should no longer have access.
            </p>
        </div>

        <div class="space-y-3">
            @forelse ($tokens as $token)
                <div class="group flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50/80 px-4 py-4 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-md">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $token->name }}</p>
                        <p class="mt-1 text-sm text-slate-500 transition-colors duration-300 group-hover:text-slate-600">
                            Created {{ $token->created_at?->diffForHumans() }}
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="revokeToken({{ $token->id }})"
                        wire:loading.attr="disabled"
                        wire:target="revokeToken({{ $token->id }})"
                        class="inline-flex items-center rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-red-200 hover:bg-red-50 hover:text-red-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-red-100 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="revokeToken({{ $token->id }})">Revoke</span>
                        <span wire:loading wire:target="revokeToken({{ $token->id }})">Revoking...</span>
                    </button>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/70 px-6 py-10 text-center transition-all duration-300 hover:border-slate-400 hover:bg-slate-50">
                    <p class="text-sm font-medium text-slate-700">No API tokens yet.</p>
                    <p class="mt-1 text-sm text-slate-500">
                        Create one above for a mobile app, Postman, or a future frontend client.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</div>

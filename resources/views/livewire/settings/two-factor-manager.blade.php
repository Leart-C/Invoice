<div class="space-y-8">
    <section class="rounded-3xl border border-slate-200 bg-white/95 p-7 shadow-sm">
        <div class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Security</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">Two-Factor Authentication</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">
                Add an extra layer of protection to your account using an authenticator app.
            </p>
        </div>
    </section>

    @if (session()->has('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/90 px-5 py-4 text-sm text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @error('twoFactor')
        <div class="rounded-2xl border border-red-200 bg-red-50/90 px-5 py-4 text-sm text-red-700 shadow-sm">
            {{ $message }}
        </div>
    @enderror

    <section class="rounded-3xl border border-slate-200 bg-white/95 p-7 shadow-sm space-y-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Status</h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $enabled ? 'Two-factor authentication is enabled for your account.' : 'Two-factor authentication is currently disabled.' }}
            </p>
        </div>

        @if (! $enabled)
            <button
                type="button"
                wire:click="enable"
                class="inline-flex items-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
            >
                Enable Two-Factor Authentication
            </button>
        @else
            <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5">
                <p class="text-sm font-medium text-slate-800">
                    {{ $confirmed ? 'Two-factor authentication is confirmed.' : 'Scan the QR code and confirm setup with a valid code.' }}
                </p>
            </div>

            @if ($qrCodeSvg)
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 mb-3">QR Code</h3>
                    <div class="inline-block rounded-2xl border border-slate-200 bg-white p-4">
                        {!! $qrCodeSvg !!}
                    </div>
                </div>
            @endif

            @if (! $confirmed)
                <form wire:submit="confirm" class="space-y-4">
                    <div>
                        <label for="code" class="block text-sm font-medium text-slate-700">Authentication Code</label>
                        <input
                            wire:model="code"
                            id="code"
                            type="text"
                            class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900"
                            placeholder="Enter the 6-digit code"
                        >
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-medium text-white shadow-sm transition hover:bg-slate-800"
                    >
                        Confirm Two-Factor Authentication
                    </button>
                </form>
            @endif

            @if ($recoveryCodes && count($recoveryCodes))
                <div>
                    <div class="flex items-center justify-between gap-4 mb-3">
                        <h3 class="text-sm font-semibold text-slate-900">Recovery Codes</h3>
                        <button
                            type="button"
                            wire:click="regenerateRecoveryCodes"
                            class="inline-flex items-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400"
                        >
                            Regenerate Codes
                        </button>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach ($recoveryCodes as $recoveryCode)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <code class="text-sm text-slate-800">{{ $recoveryCode }}</code>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-2">
                <button
                    type="button"
                    wire:click="disable"
                    class="inline-flex items-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-medium text-red-700 transition hover:bg-red-100"
                >
                    Disable Two-Factor Authentication
                </button>
            </div>
        @endif
    </section>
</div>

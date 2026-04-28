<div wire:poll.10s="loadMetrics" class="space-y-8">

    {{-- Metrics --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Revenue</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">
                ${{ number_format($metrics['totalRevenue'], 2) }}
            </p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Outstanding</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">
                ${{ number_format($metrics['outstanding'], 2) }}
            </p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Overdue</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">
                {{ $metrics['overdue'] }}
            </p>
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Clients</p>
            <p class="mt-2 text-2xl font-semibold text-slate-900">
                {{ $metrics['clients'] }}
            </p>
        </div>
    </div>

    {{-- Insights --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-800">Revenue Overview</h3>

            <div class="mt-5 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">This Month</span>
                    <span class="font-medium text-slate-900">
                        ${{ number_format($revenueComparison['thisMonth'], 2) }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Last Month</span>
                    <span class="font-medium text-slate-900">
                        ${{ number_format($revenueComparison['lastMonth'], 2) }}
                    </span>
                </div>

                <div class="flex items-center justify-between border-t border-slate-100 pt-3">
                    <span class="text-slate-600">Difference</span>
                    <span class="text-base font-semibold text-slate-900">
                        ${{ number_format($revenueComparison['difference'], 2) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-800">Top Clients</h3>

            <div class="mt-5 space-y-3">
                @forelse($topClients as $client)
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 text-sm last:border-b-0 last:pb-0">
                        <span class="text-slate-700">{{ $client->name }}</span>
                        <span class="font-medium text-slate-900">
                            ${{ number_format($client->balance, 2) }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">No client balances available.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Due Soon --}}
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-800">Due Soon</h3>
            <span class="text-sm text-slate-400">Next 7 days</span>
        </div>

        <div class="mt-5 space-y-3">
            @forelse($dueSoonInvoices as $invoice)
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 text-sm last:border-b-0 last:pb-0">
                    <div>
                        <p class="font-medium text-slate-900">{{ $invoice->invoice_number }}</p>
                        <p class="text-slate-500">{{ $invoice->client->name }}</p>
                    </div>

                    <span class="font-medium text-red-500">
                        {{ $invoice->due_date->format('M d') }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-slate-400">No upcoming invoices.</p>
            @endforelse
        </div>
    </div>

</div>

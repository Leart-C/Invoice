<div wire:poll.10s="loadMetrics" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-xl font-bold">${{ number_format($metrics['totalRevenue'], 2) }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Outstanding</p>
            <p class="text-xl font-bold">${{ number_format($metrics['outstanding'], 2) }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Overdue</p>
            <p class="text-xl font-bold">{{ $metrics['overdue'] }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <p class="text-sm text-gray-500">Clients</p>
            <p class="text-xl font-bold">{{ $metrics['clients'] }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="font-semibold text-gray-700 mb-3">Revenue</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>This Month</span>
                        <span class="font-medium">${{ number_format($revenueComparison['thisMonth'], 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Last Month</span>
                        <span class="font-medium">${{ number_format($revenueComparison['lastMonth'], 2) }}</span>
                    </div>

                    <div class="flex justify-between border-t pt-2">
                        <span>Difference</span>
                        <span class="font-bold">
                            ${{ number_format($revenueComparison['difference'], 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow">
                <h3 class="font-semibold text-gray-700 mb-3">Top Clients</h3>

                <div class="space-y-2">
                    @foreach($topClients as $client)
                    <div class="flex justify-between text-sm">
                        <span>{{ $client->name }}</span>
                        <span class="font-medium">${{ number_format($client->balance, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="bg-white p-5 rounded-xl shadow">
            <h3 class="font-semibold text-gray-700 mb-3">Due Soon (Next 7 Days)</h3>

            @forelse($dueSoonInvoices as $invoice)
            <div class="flex justify-between text-sm border-b py-2">
                <span>{{ $invoice->invoice_number }}</span>
                <span class="text-red-500">
                    {{ $invoice->due_date->format('M d') }}
                </span>
            </div>
            @empty
            <p class="text-sm text-gray-400">No upcoming invoices</p>
            @endforelse
        </div>

    </div>
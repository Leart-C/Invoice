<div>
    
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $client->name }}</h1>
                <p class="text-sm text-gray-500">{{ $client->email }}</p>
                <p class="text-sm text-gray-500">{{ $client->company_name ?? '—' }}</p>
                <p class="text-sm text-gray-500">{{ $client->phone ?? '—' }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Outstanding Balance</p>
                <p class="text-2xl font-bold {{ $outstandingBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ${{ number_format($outstandingBalance, 2) }}
                </p>
            </div>
        </div>
    </div>

    
    <h2 class="text-lg font-bold text-gray-800 mb-3">Invoice History</h2>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Invoice #</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Status</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Total</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Paid</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Due Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($invoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-blue-600">{{ $invoice->invoice_number }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $invoice->status === 'overdue' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $invoice->status === 'sent' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $invoice->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $invoice->status === 'draft' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">${{ number_format($invoice->total, 2) }}</td>
                        <td class="px-4 py-3">${{ number_format($invoice->amount_paid, 2) }}</td>
                        <td class="px-4 py-3">{{ $invoice->due_date->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No invoices yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
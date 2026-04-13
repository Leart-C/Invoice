<div>
    @if(session('success'))
        <div style="margin-bottom:16px; padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; color:#15803d; font-size:14px;">
            {{ session('success') }}
        </div>
    @endif

    
    <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px;">
        <div>
            <h1 style="font-size:20px; font-weight:700; color:#111827;">{{ $invoice->invoice_number }}</h1>
            <p style="font-size:14px; color:#6b7280; margin-top:4px;">{{ $invoice->client->name }} — {{ $invoice->client->company_name }}</p>
        </div>
        <div style="display:flex; gap:8px; align-items:center;">
            @php
                $statusColors = [
                    'draft'   => 'background:#f3f4f6; color:#374151;',
                    'sent'    => 'background:#dbeafe; color:#1d4ed8;',
                    'paid'    => 'background:#dcfce7; color:#15803d;',
                    'partial' => 'background:#fef9c3; color:#854d0e;',
                    'overdue' => 'background:#fee2e2; color:#dc2626;',
                ];
            @endphp
            <span style="padding:4px 14px; border-radius:99px; font-size:13px; font-weight:500; {{ $statusColors[$invoice->status] ?? '' }}">
                {{ ucfirst($invoice->status) }}
            </span>

            @if($invoice->status === 'draft')
                <button wire:click="markAsSent"
                        style="padding:8px 16px; background:#15803d; color:white; border:none; border-radius:8px; font-size:13px; cursor:pointer; font-family:inherit;">
                    Mark as Sent
                </button>
                <a href="{{ route('invoices.edit', $invoice) }}"
                   style="padding:8px 16px; background:#2563eb; color:white; border-radius:8px; font-size:13px; text-decoration:none;">
                    Edit
                </a>
            @endif

            <a href="{{ route('invoices.index') }}"
               style="padding:8px 16px; border:1px solid #d1d5db; border-radius:8px; font-size:13px; text-decoration:none; color:#374151;">
                Back
            </a>
        </div>
    </div>

    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
        <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:20px;">
            <p style="font-size:12px; color:#6b7280; margin-bottom:2px;">Issue Date</p>
            <p style="font-size:14px; font-weight:500; color:#111827;">{{ $invoice->issue_date->format('M d, Y') }}</p>
        </div>
        <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:20px;">
            <p style="font-size:12px; color:#6b7280; margin-bottom:2px;">Due Date</p>
            <p style="font-size:14px; font-weight:500; color:#111827;">{{ $invoice->due_date->format('M d, Y') }}</p>
        </div>
        <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:20px;">
            <p style="font-size:12px; color:#6b7280; margin-bottom:2px;">Total</p>
            <p style="font-size:18px; font-weight:700; color:#111827;">${{ number_format($invoice->total, 2) }}</p>
        </div>
        <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:20px;">
            <p style="font-size:12px; color:#6b7280; margin-bottom:2px;">Remaining Balance</p>
            <p style="font-size:18px; font-weight:700; color:{{ $invoice->remaining_balance > 0 ? '#dc2626' : '#15803d' }};">
                ${{ number_format($invoice->remaining_balance, 2) }}
            </p>
        </div>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; margin-bottom:24px;">
        <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb;">
            <h2 style="font-size:15px; font-weight:600; color:#111827;">Line Items</h2>
        </div>
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f9fafb;">
                    <th style="text-align:left; padding:10px 20px; color:#6b7280; font-weight:500;">Description</th>
                    <th style="text-align:right; padding:10px 20px; color:#6b7280; font-weight:500;">Qty</th>
                    <th style="text-align:right; padding:10px 20px; color:#6b7280; font-weight:500;">Unit Price</th>
                    <th style="text-align:right; padding:10px 20px; color:#6b7280; font-weight:500;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:10px 20px; color:#374151;">{{ $item->description }}</td>
                        <td style="padding:10px 20px; color:#374151; text-align:right;">{{ $item->quantity }}</td>
                        <td style="padding:10px 20px; color:#374151; text-align:right;">${{ number_format($item->unit_price, 2) }}</td>
                        <td style="padding:10px 20px; color:#374151; text-align:right; font-weight:500;">${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="border-top:2px solid #e5e7eb; background:#f9fafb;">
                    <td colspan="3" style="padding:10px 20px; text-align:right; font-weight:600; color:#374151;">Subtotal</td>
                    <td style="padding:10px 20px; text-align:right; font-weight:600;">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td colspan="3" style="padding:10px 20px; text-align:right; color:#6b7280;">Tax ({{ $invoice->tax }}%)</td>
                    <td style="padding:10px 20px; text-align:right; color:#6b7280;">${{ number_format($invoice->total - $invoice->subtotal, 2) }}</td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td colspan="3" style="padding:12px 20px; text-align:right; font-weight:700; font-size:15px; color:#111827;">Total</td>
                    <td style="padding:12px 20px; text-align:right; font-weight:700; font-size:15px; color:#111827;">${{ number_format($invoice->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb;">
            <h2 style="font-size:15px; font-weight:600; color:#111827;">Payment History</h2>
        </div>
        @forelse($invoice->payments as $payment)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 20px; border-bottom:1px solid #f3f4f6;">
                <div>
                    <p style="font-size:14px; font-weight:500; color:#111827;">${{ number_format($payment->amount, 2) }}</p>
                    <p style="font-size:12px; color:#6b7280;">{{ ucfirst(str_replace('_', ' ', $payment->method)) }} — {{ $payment->payment_date->format('M d, Y') }}</p>
                </div>
                @if($payment->notes)
                    <p style="font-size:13px; color:#6b7280;">{{ $payment->notes }}</p>
                @endif
            </div>
        @empty
            <div style="padding:32px; text-align:center; color:#9ca3af; font-size:14px;">
                No payments recorded yet.
            </div>
        @endforelse
    </div>
</div>
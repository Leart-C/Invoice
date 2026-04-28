<div>
    @if(session('success'))
        <div style="margin-bottom:16px; padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; color:#15803d; font-size:14px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="margin-bottom:16px; padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:8px; color:#dc2626; font-size:14px;">
            {{ session('error') }}
        </div>
    @endif

    
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:20px; font-weight:700; color:#111827;">Invoices</h1>
        
        @if(auth()->user()->role !== 'viewer')
            <a href="{{ route('invoices.create') }}"
               style="background:#2563eb; color:white; padding:8px 16px; border-radius:8px; font-size:14px; text-decoration:none; font-weight:500;">
                New Invoice
            </a>
        @endif
        
    </div>

    
    <div style="display:flex; gap:12px; margin-bottom:16px;">
        <input wire:model.live.debounce.300ms="search"
               type="text"
               placeholder="Search invoice number..."
               style="flex:1; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">

        <select wire:model.live="status"
                style="border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
            <option value="">All Statuses</option>
            <option value="draft">Draft</option>
            <option value="sent">Sent</option>
            <option value="paid">Paid</option>
            <option value="partial">Partial</option>
            <option value="overdue">Overdue</option>
        </select>

        <select wire:model.live="client_id"
                style="border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
            <option value="">All Clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Invoice #</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Client</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Status</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Total</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Due Date</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    @php
                        $statusColors = [
                            'draft'   => 'background:#f3f4f6; color:#374151;',
                            'sent'    => 'background:#dbeafe; color:#1d4ed8;',
                            'paid'    => 'background:#dcfce7; color:#15803d;',
                            'partial' => 'background:#fef9c3; color:#854d0e;',
                            'overdue' => 'background:#fee2e2; color:#dc2626;',
                        ];
                        $badge = $statusColors[$invoice->status] ?? '';
                    @endphp
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:12px 16px; font-weight:500; color:#2563eb;">
                            <a href="{{ route('invoices.show', $invoice) }}" style="text-decoration:none; color:#2563eb;">
                                {{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td style="padding:12px 16px; color:#374151;">{{ $invoice->client->name }}</td>
                        <td style="padding:12px 16px;">
                            <span style="padding:3px 10px; border-radius:99px; font-size:12px; font-weight:500; {{ $badge }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; color:#374151;">${{ number_format($invoice->total, 2) }}</td>
                        <td style="padding:12px 16px; color:#374151;">{{ $invoice->due_date->format('M d, Y') }}</td>
                        <td style="padding:12px 16px;">
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route('invoices.show', $invoice) }}"
                                   style="font-size:13px; color:#6b7280; text-decoration:none;">View</a>

                                   @can('downloadPdf',$invoice)
                                        <a href="{{route('invoices.pdf',$invoice->id)}}">
                                            PDF
                                        </a>                                       
                                   @endcan

                                @if($invoice->canBeEdited())
                                    <a href="{{ route('invoices.edit', $invoice) }}"
                                       style="font-size:13px; color:#2563eb; text-decoration:none;">Edit</a>
                                @endif

                                @if($invoice->status === 'draft')
                                    <button wire:click="markAsSent({{ $invoice->id }})"
                                            style="font-size:13px; color:#15803d; background:none; border:none; cursor:pointer; font-family:inherit; padding:0;">
                                        Mark Sent
                                    </button>
                                @endif

                                @if($invoice->canBeDeleted())
                                    <button wire:click="confirmDelete({{ $invoice->id }})"
                                            style="font-size:13px; color:#dc2626; background:none; border:none; cursor:pointer; font-family:inherit; padding:0;">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:40px; text-align:center; color:#9ca3af;">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <div style="margin-top:16px;">
        {{ $invoices->links() }}
    </div>

    
    @if($showDeleteModal)
        <div style="position:fixed; inset:0; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; z-index:50;">
            <div style="background:white; border-radius:12px; padding:24px; width:100%; max-width:360px;">
                <h3 style="font-weight:700; color:#111827; margin-bottom:8px;">Delete Invoice</h3>
                <p style="font-size:14px; color:#6b7280; margin-bottom:24px;">Are you sure? This cannot be undone.</p>
                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <button wire:click="$set('showDeleteModal', false)"
                            style="padding:8px 16px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; cursor:pointer; background:white;">
                        Cancel
                    </button>
                    <button wire:click="delete"
                            style="padding:8px 16px; background:#dc2626; color:white; border:none; border-radius:8px; font-size:14px; cursor:pointer;">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
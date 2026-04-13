<div>
    @if(session('success'))
        <div style="margin-bottom:16px; padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; color:#15803d; font-size:14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb;">
            <h2 style="font-size:15px; font-weight:600; color:#111827;">Payment History</h2>
        </div>

        @forelse($payments as $payment)
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #f3f4f6;">
                <div style="display:flex; flex-direction:column; gap:2px;">
                    <span style="font-size:15px; font-weight:600; color:#111827;">
                        ${{ number_format($payment->amount, 2) }}
                    </span>
                    <span style="font-size:12px; color:#6b7280;">
                        {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                        · {{ $payment->payment_date->format('M d, Y') }}
                        @if($payment->notes) · {{ $payment->notes }} @endif
                    </span>
                </div>

                @if(auth()->user()->role === 'admin')
                    <button wire:click="confirmDelete({{ $payment->id }})"
                            style="font-size:12px; color:#dc2626; background:none; border:none; cursor:pointer; font-family:inherit; padding:4px 8px;">
                        Delete
                    </button>
                @endif
            </div>
        @empty
            <div style="padding:32px; text-align:center; color:#9ca3af; font-size:14px;">
                No payments recorded yet.
            </div>
        @endforelse
    </div>

    
    @if($showDeleteModal)
        <div style="position:fixed; inset:0; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; z-index:50;">
            <div style="background:white; border-radius:12px; padding:24px; width:100%; max-width:360px;">
                <h3 style="font-weight:700; color:#111827; margin-bottom:8px;">Delete Payment</h3>
                <p style="font-size:14px; color:#6b7280; margin-bottom:24px;">
                    This will recalculate the invoice balance automatically.
                </p>
                <div style="display:flex; gap:12px; justify-content:flex-end;">
                    <button wire:click="cancelDelete"
                            style="padding:8px 16px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; cursor:pointer; background:white; font-family:inherit;">
                        Cancel
                    </button>
                    <button wire:click="delete"
                            style="padding:8px 16px; background:#dc2626; color:white; border:none; border-radius:8px; font-size:14px; cursor:pointer; font-family:inherit;">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
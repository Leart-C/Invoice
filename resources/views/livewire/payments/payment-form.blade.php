<div style="max-width:560px;">

    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
        <a href="{{ route('invoices.show', $invoice) }}"
           style="font-size:13px; color:#6b7280; text-decoration:none;">
            ← Back to {{ $invoice->invoice_number }}
        </a>
    </div>

    <h1 style="font-size:20px; font-weight:700; color:#111827; margin-bottom:4px;">
        Record Payment
    </h1>
    <p style="font-size:14px; color:#6b7280; margin-bottom:24px;">
        {{ $invoice->invoice_number }} — {{ $invoice->client->name }}
    </p>

    
    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:24px;">
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px;">
            <p style="font-size:11px; color:#6b7280; margin-bottom:2px;">Invoice Total</p>
            <p style="font-size:16px; font-weight:700; color:#111827;">${{ number_format($invoice->total, 2) }}</p>
        </div>
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px;">
            <p style="font-size:11px; color:#6b7280; margin-bottom:2px;">Already Paid</p>
            <p style="font-size:16px; font-weight:700; color:#15803d;">${{ number_format($invoice->amount_paid, 2) }}</p>
        </div>
        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:14px;">
            <p style="font-size:11px; color:#dc2626; margin-bottom:2px;">Remaining</p>
            <p style="font-size:16px; font-weight:700; color:#dc2626;">${{ number_format($invoice->remaining_balance, 2) }}</p>
        </div>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:24px;">

        <div style="display:flex; flex-direction:column; gap:16px;">

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Amount *</label>
                <input wire:model="amount"
                       type="number" min="0.01" step="0.01"
                       style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                @error('amount')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Payment Date *</label>
                <input wire:model="payment_date"
                       type="date"
                       style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                @error('payment_date')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Payment Method *</label>
                <select wire:model="method"
                        style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="card">Card</option>
                    <option value="other">Other</option>
                </select>
                @error('method')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Notes</label>
                <textarea wire:model="notes" rows="3"
                          style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none; resize:vertical;"></textarea>
                @error('notes')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div style="display:flex; gap:12px; margin-top:20px;">
            <button wire:click="save"
                    style="background:#7c3aed; color:white; padding:10px 24px; border-radius:8px; font-size:14px; border:none; cursor:pointer; font-weight:500; font-family:inherit;">
                Record Payment
            </button>
            <a href="{{ route('invoices.show', $invoice) }}"
               style="padding:10px 24px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; text-decoration:none; color:#374151;">
                Cancel
            </a>
        </div>

    </div>
</div>
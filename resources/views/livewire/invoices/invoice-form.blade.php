<div style="max-width:800px;">

    <h1 style="font-size:20px; font-weight:700; color:#111827; margin-bottom:24px;">
        {{ $invoice ? 'Edit Invoice' : 'New Invoice' }}
    </h1>

    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:24px; margin-bottom:24px;">

        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

            <div style="grid-column:span 2;">
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Client *</label>
                <select wire:model="client_id"
                        style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                    <option value="">Select a client...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} — {{ $client->company_name }}</option>
                    @endforeach
                </select>
                @error('client_id') <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Issue Date *</label>
                <input wire:model="issue_date" type="date"
                       style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                @error('issue_date') <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Due Date *</label>
                <input wire:model="due_date" type="date"
                       style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                @error('due_date') <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Tax %</label>
                <input wire:model.live="tax" type="number" min="0" max="100" step="0.01"
                       style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
                @error('tax') <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            </div>

            <div style="grid-column:span 2;">
                <label style="display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:4px;">Notes</label>
                <textarea wire:model="notes" rows="2"
                          style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none; resize:vertical;"></textarea>
            </div>

        </div>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:24px; margin-bottom:24px;">
        <h2 style="font-size:15px; font-weight:600; color:#111827; margin-bottom:16px;">Line Items</h2>

        @foreach($items as $index => $item)
            <div style="display:grid; grid-template-columns:1fr 100px 120px 100px 36px; gap:8px; margin-bottom:8px; align-items:start;">

                <div>
                    @if($index === 0)
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:4px;">Description</label>
                    @endif
                    <input wire:model.live="items.{{ $index }}.description"
                           type="text" placeholder="Description"
                           style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:14px; outline:none;">
                    @error("items.$index.description") <p style="color:#dc2626; font-size:11px; margin-top:2px;">{{ $message }}</p> @enderror
                </div>

                <div>
                    @if($index === 0)
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:4px;">Qty</label>
                    @endif
                    <input wire:model.live="items.{{ $index }}.quantity"
                           type="number" min="0.01" step="0.01" placeholder="1"
                           style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:14px; outline:none;">
                </div>

                <div>
                    @if($index === 0)
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:4px;">Unit Price</label>
                    @endif
                    <input wire:model.live="items.{{ $index }}.unit_price"
                           type="number" min="0" step="0.01" placeholder="0.00"
                           style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:8px 10px; font-size:14px; outline:none;">
                </div>

                <div>
                    @if($index === 0)
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:4px;">Total</label>
                    @endif
                    <input type="text" readonly
                           value="${{ number_format($item['total'] ?? 0, 2) }}"
                           style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 10px; font-size:14px; background:#f9fafb; color:#6b7280;">
                </div>

                <div>
                    @if($index === 0)
                        <label style="display:block; font-size:12px; color:transparent; margin-bottom:4px;">X</label>
                    @endif
                    @if(count($items) > 1)
                        <button wire:click="removeItem({{ $index }})"
                                style="width:36px; height:36px; border:1px solid #fecaca; border-radius:8px; background:#fef2f2; color:#dc2626; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">
                            &times;
                        </button>
                    @endif
                </div>

            </div>
        @endforeach

        <button wire:click="addItem"
                style="margin-top:8px; font-size:14px; color:#2563eb; background:none; border:none; cursor:pointer; font-family:inherit; padding:0; font-weight:500;">
            + Add Line Item
        </button>
    </div>

    
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; padding:24px; margin-bottom:24px;">
        <div style="display:flex; flex-direction:column; gap:8px; max-width:300px; margin-left:auto;">
            <div style="display:flex; justify-content:space-between; font-size:14px; color:#6b7280;">
                <span>Subtotal</span>
                <span>${{ number_format($this->subtotal, 2) }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:14px; color:#6b7280;">
                <span>Tax ({{ $tax }}%)</span>
                <span>${{ number_format($this->taxAmount, 2) }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; font-size:16px; font-weight:700; color:#111827; border-top:1px solid #e5e7eb; padding-top:8px; margin-top:4px;">
                <span>Total</span>
                <span>${{ number_format($this->total, 2) }}</span>
            </div>
        </div>
    </div>

    
    <div style="display:flex; gap:12px;">
        <button wire:click="save"
                style="background:#2563eb; color:white; padding:10px 24px; border-radius:8px; font-size:14px; border:none; cursor:pointer; font-weight:500; font-family:inherit;">
            {{ $invoice ? 'Update Invoice' : 'Create Invoice' }}
        </button>
        <a href="{{ route('invoices.index') }}"
           style="padding:10px 24px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; text-decoration:none; color:#374151; font-weight:500;">
            Cancel
        </a>
    </div>

</div>
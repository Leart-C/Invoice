<div>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <h1 style="font-size:20px; font-weight:700; color:#111827;">Audit Log</h1>
    </div>

    
    <div style="display:flex; gap:12px; margin-bottom:16px;">
        <select wire:model.live="filterModel"
                style="border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
            <option value="">All Models</option>
            @foreach($modelTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>

        <select wire:model.live="filterAction"
                style="border:1px solid #d1d5db; border-radius:8px; padding:8px 12px; font-size:14px; outline:none;">
            <option value="">All Actions</option>
            @foreach($actionTypes as $action)
                <option value="{{ $action }}">{{ ucfirst($action) }}</option>
            @endforeach
        </select>
    </div>

   
    <div style="background:white; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">When</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">User</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Action</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Model</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Record ID</th>
                    <th style="text-align:left; padding:12px 16px; color:#6b7280; font-weight:500;">Changes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    @php
                        $actionColors = [
                            'created' => 'background:#dcfce7; color:#15803d;',
                            'updated' => 'background:#dbeafe; color:#1d4ed8;',
                            'deleted' => 'background:#fee2e2; color:#dc2626;',
                        ];
                    @endphp
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:12px 16px; color:#6b7280; font-size:13px;">
                            {{ $log->created_at->format('M d, Y H:i') }}
                        </td>
                        <td style="padding:12px 16px; color:#374151;">
                            {{ $log->user?->name ?? 'System' }}
                        </td>
                        <td style="padding:12px 16px;">
                            <span style="padding:3px 10px; border-radius:99px; font-size:12px; font-weight:500; {{ $actionColors[$log->action] ?? '' }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; color:#374151;">{{ $log->model_type }}</td>
                        <td style="padding:12px 16px; color:#374151;">#{{ $log->model_id }}</td>
                        <td style="padding:12px 16px;">
                            @if($log->action === 'updated' && $log->old_values && $log->new_values)
                                <div style="font-size:12px;">
                                    @foreach($log->new_values as $field => $newVal)
                                        <div style="margin-bottom:2px;">
                                            <span style="color:#6b7280;">{{ $field }}:</span>
                                            <span style="color:#dc2626; text-decoration:line-through;">
                                                {{ $log->old_values[$field] ?? '—' }}
                                            </span>
                                            →
                                            <span style="color:#15803d;">{{ $newVal }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($log->action === 'created')
                                <span style="font-size:12px; color:#6b7280;">New record created</span>
                            @elseif($log->action === 'deleted')
                                <span style="font-size:12px; color:#6b7280;">Record deleted</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:40px; text-align:center; color:#9ca3af;">
                            No audit logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">
        {{ $logs->links() }}
    </div>
</div>
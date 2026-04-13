<div>
    
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Clients</h1>
        
        @if(auth()->user()->role !== 'viewer')
            <a href="{{ route('clients.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Add Client
            </a>
        @endif
    </div>

    
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search"
               type="text"
               placeholder="Search by name, email or company..."
               class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Name</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Email</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Company</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Invoices</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Outstanding</th>
                    <th class="text-left px-4 py-3 text-gray-600 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($clients as $client)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            <a href="{{ route('clients.show', $client) }}" class="hover:text-blue-600">
                                {{ $client->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $client->email }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $client->company_name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $client->invoices_count }}</td>
                        <td class="px-4 py-3">
                            <span class="{{ $client->outstanding_balance > 0 ? 'text-red-600' : 'text-green-600' }} font-medium">
                                ${{ number_format($client->outstanding_balance, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if(auth()->user()->role !== 'viewer')
                                <div class="flex gap-2">
                                    <a href="{{ route('client.edit', $client) }}"
                                       class="text-blue-600 hover:underline text-xs">Edit</a>
                                    <button wire:click="confirmDelete({{ $client->id }})"
                                            class="text-red-500 hover:underline text-xs">Delete</button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No clients found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <div class="mt-4">
        {{ $clients->links() }}
    </div>

    
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-sm shadow-lg">
                <h3 class="font-bold text-gray-800 mb-2">Delete Client</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure? This action cannot be undone.</p>
                <div class="flex gap-3 justify-end">
                    <button wire:click="cancelDelete"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="delete"
                            class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
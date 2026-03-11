<div>
    @section('title', 'Blood Sugar Records')

    <h1 class="text-2xl font-bold text-white mb-8">Blood Sugar Records</h1>

    {{-- Search --}}
    <div class="flex gap-3 mb-6">
        <div class="relative w-72">
            <input wire:model.live.debounce.300ms="search" placeholder="Search by user name or email…"
                   class="w-full bg-gray-900 border border-white/10 rounded-lg pl-10 pr-4 py-2 text-sm text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <div wire:loading class="flex items-center text-sm text-indigo-400">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            Loading...
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden relative min-h-[400px]">
        {{-- Loading overlay --}}
        <div wire:loading.delay.longer class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm z-10 flex items-center justify-center">
            <div class="bg-gray-800 rounded-lg px-4 py-2 shadow-xl border border-white/10 text-sm flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Processing...
            </div>
        </div>

        <table class="w-full text-sm">
            <thead>
            <tr class="text-xs text-gray-500 border-b border-white/5 bg-gray-900/50">
                <th class="px-6 py-4 text-left font-medium tracking-wider">User</th>
                <th class="px-6 py-4 text-left font-medium tracking-wider">Value (mmol/L)</th>
                <th class="px-6 py-4 text-left font-medium tracking-wider">Recorded At</th>
                <th class="px-6 py-4 text-left font-medium tracking-wider">Notes</th>
                <th class="px-6 py-4 text-right font-medium tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
            @forelse($records as $record)
                <tr class="hover:bg-white/[0.02] transition-colors" wire:key="bs-{{ $record->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-800 text-xs flex items-center justify-center border border-white/10 font-bold text-white shrink-0">
                                {{ strtoupper(substr($record->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-white">{{ $record->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $record->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold border
                            {{ $record->value > 7.0 ? 'bg-red-500/10 text-red-400 border-red-500/20' : ($record->value < 3.9 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20') }}">
                            {{ $record->value }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-sm">
                        {{ \Carbon\Carbon::parse($record->recorded_at)->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs max-w-xs truncate" title="{{ $record->notes }}">
                        {{ $record->notes ?: '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity" style="opacity: 1;">
                            <button wire:click="delete({{ $record->id }})" wire:confirm="Delete this record?" class="p-1.5 text-gray-400 hover:text-red-400 hover:bg-red-400/10 rounded-md transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="1.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3"/></svg>
                            <p>No records found.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if($records->hasPages())
            <div class="px-6 py-4 border-t border-white/5 bg-gray-900/50">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</div>

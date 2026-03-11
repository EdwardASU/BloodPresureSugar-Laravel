<div>
    @section('title', 'Dashboard')

    <h1 class="text-2xl font-bold text-white mb-8">Dashboard</h1>
{{-- Stats cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-gray-900 border border-white/5 rounded-2xl p-6 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-indigo-500/15 flex items-center justify-center">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Total Users</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl p-6 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-amber-500/15 flex items-center justify-center">
            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold">{{ $stats['total_blood_sugars'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Blood Sugar Records</p>
        </div>
    </div>

    <div class="bg-gray-900 border border-white/5 rounded-2xl p-6 flex items-center gap-5">
        <div class="w-12 h-12 rounded-xl bg-rose-500/15 flex items-center justify-center">
            <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold">{{ $stats['total_blood_pressures'] }}</p>
            <p class="text-sm text-gray-500 mt-0.5">Blood Pressure Records</p>
        </div>
    </div>
</div>

{{-- Recent records --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent blood sugars --}}
    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-300">Recent Blood Sugar</h2>
            <a href="{{ route('admin.blood-sugars.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300">View all →</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-500 border-b border-white/5">
                    <th class="px-6 py-3 text-left font-medium">User</th>
                    <th class="px-6 py-3 text-left font-medium">Value</th>
                    <th class="px-6 py-3 text-left font-medium">Recorded</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($stats['recent_blood_sugars'] as $record)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-3 text-gray-300">{{ $record->user->name }}</td>
                        <td class="px-6 py-3"><span class="font-mono text-amber-400">{{ $record->value }}</span> <span class="text-gray-500 text-xs">mmol/L</span></td>
                        <td class="px-6 py-3 text-gray-500 text-xs">{{ $record->recorded_at->format('d M H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-6 text-center text-gray-600 text-xs">No records yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent blood pressures --}}
    <div class="bg-gray-900 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-300">Recent Blood Pressure</h2>
            <a href="{{ route('admin.blood-pressures.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300">View all →</a>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-500 border-b border-white/5">
                    <th class="px-6 py-3 text-left font-medium">User</th>
                    <th class="px-6 py-3 text-left font-medium">Reading</th>
                    <th class="px-6 py-3 text-left font-medium">Recorded</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($stats['recent_blood_pressures'] as $record)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-3 text-gray-300">{{ $record->user->name }}</td>
                        <td class="px-6 py-3">
                            <span class="font-mono text-rose-400">{{ $record->systolic }}/{{ $record->diastolic }}</span>
                            <span class="text-gray-500 text-xs">mmHg</span>
                            @if($record->pulse)
                                <span class="ml-2 text-gray-500 text-xs">♥ {{ $record->pulse }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-gray-500 text-xs">{{ $record->recorded_at->format('d M H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-6 text-center text-gray-600 text-xs">No records yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>

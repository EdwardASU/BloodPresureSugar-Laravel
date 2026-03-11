<div>
    @section('title', 'Users')

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-white">Users</h1>
        <button wire:click="create"
                class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors shadow-sm">
            + New User
        </button>
    </div>

    {{-- Search / Filter --}}
    <div class="flex gap-3 mb-6">
        <div class="relative w-72">
            <input wire:model.live.debounce.300ms="search" placeholder="Search name or email…"
                   class="w-full bg-gray-900 border border-white/10 rounded-lg pl-10 pr-4 py-2 text-sm text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <select wire:model.live="role" class="bg-gray-900 border border-white/10 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            <option value="">All roles</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        
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
                    <th class="px-6 py-4 text-left font-medium tracking-wider">Name</th>
                    <th class="px-6 py-4 text-left font-medium tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left font-medium tracking-wider">Role</th>
                    <th class="px-6 py-4 text-left font-medium tracking-wider">Created</th>
                    <th class="px-6 py-4 text-right font-medium tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors" wire:key="user-{{ $user->id }}">
                        <td class="px-6 py-4 font-medium text-white flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-800 text-xs flex items-center justify-center border border-white/10 font-bold block shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="truncate">{{ $user->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border
                                {{ $user->role === 'admin' ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' : 'bg-gray-800 text-gray-400 border-white/10' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity" style="opacity: 1;">
                                <button wire:click="edit({{ $user->id }})" class="p-1.5 text-gray-400 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-md transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" class="p-1.5 text-gray-400 hover:text-red-400 hover:bg-red-400/10 rounded-md transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p>No users found matching your filters.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-white/5 bg-gray-900/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-data @keydown.escape.window="$wire.set('showModal', false)">
            <div class="bg-gray-900 border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-gray-800/50 shrink-0">
                    <h3 class="text-base font-semibold text-white">{{ $editingId ? 'Edit User' : 'Create New User' }}</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto">
                    <form wire:submit="save" class="space-y-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">Name</label>
                            <input wire:model="name" type="text"
                                   class="w-full bg-gray-950 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @error('name')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
                            <input wire:model="email" type="email"
                                   class="w-full bg-gray-950 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 transition">
                            @error('email')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1.5">
                                    {{ $editingId ? 'New Password' : 'Password' }}
                                    @if($editingId)<span class="text-gray-600 font-normal">(optional)</span>@endif
                                </label>
                                <input wire:model="password" type="password"
                                       class="w-full bg-gray-950 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 transition">
                                @error('password')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1.5">Confirm Password</label>
                                <input wire:model="password_confirmation" type="password"
                                       class="w-full bg-gray-950 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:ring-2 focus:ring-indigo-500 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1.5">Role</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition {{ $userRole === 'user' ? 'bg-indigo-500/10 border-indigo-500/30' : '' }}">
                                    <input type="radio" wire:model="userRole" value="user" class="text-indigo-500 bg-gray-900 border-gray-700 focus:ring-indigo-500 focus:ring-offset-gray-900 focus:ring-offset-2">
                                    <div>
                                        <p class="text-sm font-medium text-white">User</p>
                                        <p class="text-xs text-gray-500">API Access Only</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-3 p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition {{ $userRole === 'admin' ? 'bg-indigo-500/10 border-indigo-500/30' : '' }}">
                                    <input type="radio" wire:model="userRole" value="admin" class="text-indigo-500 bg-gray-900 border-gray-700 focus:ring-indigo-500 focus:ring-offset-gray-900 focus:ring-offset-2">
                                    <div>
                                        <p class="text-sm font-medium text-white">Admin</p>
                                        <p class="text-xs text-gray-500">Full Dashboard Access</p>
                                    </div>
                                </label>
                            </div>
                            @error('userRole')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </form>
                </div>

                <div class="px-6 py-4 border-t border-white/5 bg-gray-800/50 flex justify-end gap-3 shrink-0">
                    <button wire:click="$set('showModal', false)"
                            class="px-5 py-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                        Cancel
                    </button>
                    <button wire:click="save"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium px-6 py-2 rounded-lg transition-colors flex items-center gap-2 shadow-sm">
                        <span wire:loading.remove wire:target="save">Save User</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

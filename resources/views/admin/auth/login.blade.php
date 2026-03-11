<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Blood Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center bg-gray-950">

<div class="w-full max-w-md px-8 py-10 bg-gray-900 border border-white/10 rounded-2xl shadow-2xl">
    <div class="text-center mb-8">
        <p class="text-2xl font-bold tracking-tight">
            <span class="text-indigo-400">Blood</span>Monitor
        </p>
        <p class="text-sm text-gray-500 mt-1">Admin Panel</p>
    </div>

    @if($errors->any())
        <div class="mb-5 bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3 rounded-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="admin@example.com">
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5">Password</label>
            <input type="password" name="password" required
                   class="w-full bg-gray-800 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="••••••••">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded border-gray-700 bg-gray-800 text-indigo-500">
            <label for="remember" class="text-sm text-gray-400">Remember me</label>
        </div>

        <button type="submit"
                class="w-full bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2.5 rounded-lg transition-colors text-sm">
            Sign in
        </button>
    </form>
</div>

</body>
</html>

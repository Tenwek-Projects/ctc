<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | {{ config('ctc.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-admin-bg font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="w-full max-w-md relative">
            <div aria-hidden="true" class="pointer-events-none absolute -inset-6 blur-2xl opacity-60">
                <div class="absolute inset-0 bg-[radial-gradient(closest-side,rgba(13,148,136,0.22),transparent_70%)]"></div>
                <div class="absolute -top-10 -right-10 h-48 w-48 rounded-full bg-[radial-gradient(circle,rgba(228,195,115,0.35),transparent_70%)]"></div>
                <div class="absolute -bottom-12 -left-12 h-56 w-56 rounded-full bg-[radial-gradient(circle,rgba(26,26,104,0.22),transparent_70%)]"></div>
            </div>

            <div class="relative rounded-2xl bg-admin-surface shadow-lg border border-gray-200 overflow-hidden">
                <div aria-hidden="true" class="h-1.5 bg-gradient-to-r from-[#1a1a68] via-[#0d9488] to-[#e4c373]"></div>
                <div class="p-8">
                    <div class="flex items-start justify-between gap-6 mb-7">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-admin-muted">Admin access</p>
                            <h1 class="mt-2 text-2xl font-extrabold text-admin-dark leading-tight">
                                {{ config('ctc.name') }}
                            </h1>
                            <p class="mt-1 text-sm text-admin-muted">Sign in to manage content and settings.</p>
                        </div>
                        <div class="shrink-0">
                            <div class="h-11 w-11 rounded-2xl border border-gray-200 bg-white/60 flex items-center justify-center shadow-sm">
                                <svg class="h-5 w-5 text-[#1a1a68]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20a8 8 0 0116 0" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{ route('admin-dashboard.login.attempt') }}" class="space-y-5" x-data="{ showPw: false }">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-semibold text-admin-dark mb-1">Email</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       class="w-full rounded-xl border border-gray-300 pl-10 pr-4 py-3 text-sm text-admin-dark focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                            </div>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-semibold text-admin-dark mb-1">Password</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m6-7V8a6 6 0 10-12 0v2m12 0H6m12 0a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2" />
                                    </svg>
                                </span>
                                <input :type="showPw ? 'text' : 'password'" name="password" id="password" required autocomplete="current-password"
                                       class="w-full rounded-xl border border-gray-300 pl-10 pr-12 py-3 text-sm text-admin-dark focus:ring-2 focus:ring-admin-teal focus:border-admin-teal">
                                <button type="button"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-xs font-semibold text-gray-500 hover:text-admin-teal transition-colors"
                                        @click="showPw = !showPw"
                                        :aria-pressed="showPw ? 'true' : 'false'"
                                        :aria-label="showPw ? 'Hide password' : 'Show password'">
                                    <span x-text="showPw ? 'Hide' : 'Show'"></span>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-600 select-none">
                                <input type="checkbox" name="remember" id="remember"
                                       class="rounded border-gray-300 text-admin-teal focus:ring-admin-teal">
                                Remember me
                            </label>
                            <a href="{{ url('/') }}" class="text-sm font-semibold text-admin-teal hover:underline">Back to site</a>
                        </div>
                        <button type="submit"
                                class="w-full rounded-xl bg-admin-teal text-white font-semibold py-3 hover:bg-admin-teal-dark transition-colors shadow-sm shadow-admin-teal/20">
                            Log in
                        </button>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Protected by two-step verification after login. If you don’t have access, contact an administrator.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

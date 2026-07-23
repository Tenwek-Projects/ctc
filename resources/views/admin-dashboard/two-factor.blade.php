<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Step Verification | {{ config('ctc.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-admin-bg font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="w-full max-w-md relative">
            <div aria-hidden="true" class="pointer-events-none absolute -inset-6 blur-2xl opacity-60">
                <div class="absolute inset-0 bg-[radial-gradient(closest-side,rgba(13,148,136,0.22),transparent_70%)]"></div>
                <div class="absolute -top-10 -right-10 h-48 w-48 rounded-full bg-[radial-gradient(circle,rgba(179,49,39,0.35),transparent_70%)]"></div>
                <div class="absolute -bottom-12 -left-12 h-56 w-56 rounded-full bg-[radial-gradient(circle,rgba(26,26,104,0.22),transparent_70%)]"></div>
            </div>

            <div class="relative rounded-2xl bg-admin-surface shadow-lg border border-gray-200 overflow-hidden">
                <div aria-hidden="true" class="h-1.5 bg-gradient-to-r from-[#1a1a68] via-[#0d9488] to-[#b33127]"></div>
                <div class="p-8">
                    <div class="mb-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-admin-muted">Two-step verification</p>
                        <h1 class="mt-2 text-2xl font-extrabold text-admin-dark">Enter your code</h1>
                @php
                    $channelLabels = collect($channels ?? ['mail'])->map(function ($c) use ($email) {
                        return match ($c) {
                            'mail' => $email,
                            'rebueTextSms' => 'your phone',
                            default => $c,
                        };
                    })->unique()->values();
                @endphp
                        <p class="mt-2 text-sm text-admin-muted">
                    We sent a 6‑digit code to
                    <span class="font-medium text-gray-700">{{ $channelLabels->join(', ', ' and ') }}</span>
                </p>
                    </div>

            @if(session('success'))
                <div class="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
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

            <form method="post" action="{{ route('admin-dashboard.two-factor.verify') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="code" class="block text-sm font-semibold text-admin-dark mb-1">Verification code</label>
                    <input
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        name="code"
                        id="code"
                        required
                        autofocus
                        class="w-full tracking-[0.4em] text-center rounded-xl border border-gray-300 px-4 py-3 text-lg text-admin-dark focus:ring-2 focus:ring-admin-teal focus:border-admin-teal"
                        placeholder="••••••"
                    >
                </div>

                <button type="submit" class="w-full rounded-xl bg-admin-teal text-white font-semibold py-3 hover:bg-admin-teal-dark transition-colors shadow-sm shadow-admin-teal/20">
                    Verify & continue
                </button>
            </form>

            <form method="post" action="{{ route('admin-dashboard.two-factor.resend') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-gray-300 bg-white text-gray-700 font-semibold py-3 hover:bg-gray-50 transition-colors">
                    Resend code
                </button>
            </form>
                    <p class="mt-6 text-center text-sm text-gray-500">
                        <a href="{{ route('admin-dashboard.login') }}" class="text-admin-teal hover:underline">Back to login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


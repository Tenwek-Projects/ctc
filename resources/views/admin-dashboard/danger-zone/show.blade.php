@extends('admin-dashboard.layouts.app')

@section('title', 'Danger zone')
@section('header', 'Danger zone')

@section('content')
    <div class="max-w-3xl space-y-6" x-data="{ selected: {{ \Illuminate\Support\Js::from(array_values(old('datasets', []))) }} }">
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-red-700">Irreversible</p>
            <h2 class="mt-2 text-lg font-semibold text-red-900">Purge test / staging data</h2>
            <p class="mt-2 text-sm text-red-800/90 leading-relaxed">
                Select the data sets you want to remove. This permanently deletes records (and related uploads where applicable).
                Site settings, users, team members, and services are never touched here.
            </p>
        </div>

        <form method="post" action="{{ route('admin-dashboard.danger-zone.purge') }}" class="space-y-6"
              onsubmit="return confirm('Permanently delete the selected data? This cannot be undone.');">
            @csrf

            @foreach($groups as $groupName => $items)
                <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-200 bg-admin-bg/40">
                        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">{{ $groupName }}</p>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @foreach($items as $item)
                            <li class="px-5 py-4">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="datasets[]"
                                        value="{{ $item['key'] }}"
                                        class="mt-1 rounded border-gray-300 text-red-600 focus:ring-red-500"
                                        x-model="selected"
                                        @checked(in_array($item['key'], old('datasets', []), true))
                                    >
                                    <span class="min-w-0 flex-1">
                                        <span class="flex flex-wrap items-center gap-2">
                                            <span class="text-sm font-semibold text-admin-dark">{{ $item['label'] }}</span>
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 tabular-nums">
                                                {{ $item['count'] }} {{ \Illuminate\Support\Str::plural('record', $item['count']) }}
                                            </span>
                                        </span>
                                        <span class="mt-1 block text-sm text-admin-muted leading-relaxed">{{ $item['description'] }}</span>
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            @error('datasets')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-5 space-y-4">
                <div>
                    <label for="confirm" class="block text-sm font-medium text-admin-dark mb-1">
                        Type <span class="font-mono font-bold text-red-700">PURGE</span> to confirm
                    </label>
                    <input
                        type="text"
                        name="confirm"
                        id="confirm"
                        value="{{ old('confirm') }}"
                        autocomplete="off"
                        placeholder="PURGE"
                        class="w-full max-w-xs rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-mono tracking-widest focus:border-red-500 focus:ring-red-500"
                    >
                    @error('confirm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="selected.length === 0"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Purge selected data
                </button>
            </div>
        </form>
    </div>
@endsection

@props(['title' => null, 'searchUrl' => null, 'searchPlaceholder' => 'Search...'])
<div class="rounded-xl border border-gray-200 bg-admin-surface shadow-sm overflow-hidden">
    @if($title || $searchUrl)
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            @if($title)<p class="text-sm font-medium text-admin-dark">{{ $title }}</p>@endif
            @if($searchUrl)
                <form action="{{ $searchUrl }}" method="get" class="flex gap-2">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}"
                           class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:ring-2 focus:ring-admin-teal focus:border-admin-teal w-40 sm:w-56">
                    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                    <button type="submit" class="rounded-lg bg-admin-teal text-white px-3 py-1.5 text-sm font-medium hover:bg-admin-teal-dark">Search</button>
                </form>
            @endif
        </div>
    @endif
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>
    @if(isset($pagination))
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $pagination }}
        </div>
    @endif
</div>


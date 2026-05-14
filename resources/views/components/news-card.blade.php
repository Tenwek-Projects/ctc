@props([
    'title',
    'excerpt' => null,
    'excerptPlain' => null,
    'type' => 'news',
    'date' => null,
    'image' => null,
    'url' => null,
])

@php
    $tag = $url ? 'a' : 'article';
    $url = $url ?? '#';
    $fallback = 'https://images.unsplash.com/photo-1580281658629-99bb1fd55b0a?auto=format&fit=crop&w=1200&q=60';
    $img = \App\Support\PublicAssetUrl::toUrl($image) ?: $fallback;

    $excerptPlain = $excerptPlain
        ?? (filled($excerpt)
            ? \Illuminate\Support\Str::of($excerpt)->stripTags()->squish()->limit(140)
            : null);
@endphp

<{{ $tag }} href="{{ $url }}"
   class="ctc-card-tilt block rounded-xl bg-white border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition-[box-shadow] duration-500 group">
    <div class="aspect-video bg-ctc-grey-light overflow-hidden">
        <img src="{{ $img }}" alt="{{ $title }}" class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.04]" loading="lazy">
    </div>
    <div class="p-5">
        @if($type)
            <span class="inline-block text-xs font-medium uppercase tracking-wide text-ctc-ruby mb-2">{{ $type }}</span>
        @endif
        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-ctc-blue transition-colors">{{ $title }}</h3>
        @if($date)
            <p class="text-sm text-gray-500 mt-1">{{ $date?->format('F j, Y') ?? $date }}</p>
        @endif
        @if($excerptPlain)
            <p class="mt-2 text-gray-600 text-sm leading-relaxed line-clamp-2">{{ $excerptPlain }}</p>
        @endif
    </div>
</{{ $tag }}>

@props([
    'name',
    'title',
    'specialization' => null,
    'bio' => null,
    'photo' => null,
    'url' => null,
])

@php
    $tag = $url ? 'a' : 'article';
    $href = $url ?: null;
    $bioPlain = $bio ? \Illuminate\Support\Str::limit(trim(strip_tags($bio)), 220) : null;
    $photoUrl = \App\Support\PublicAssetUrl::toUrl($photo);
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    class="ctc-card-tilt group rounded-2xl bg-white border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-[box-shadow] duration-500 block">
    <div class="aspect-[4/3] bg-ctc-grey-light flex items-center justify-center relative overflow-hidden">
        @if($photoUrl)
            <img src="{{ $photoUrl }}" alt="{{ $name }}" class="w-full h-full object-cover grayscale-[0.35] transition-[filter,transform] duration-700 ease-out group-hover:scale-[1.03] group-hover:grayscale-0">
        @else
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity" aria-hidden="true"></div>
    </div>
    <div class="p-5">
        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-ctc-ruby/90">Specialist</p>
        <h3 class="mt-2 text-lg font-semibold text-gray-900">{{ $name }}</h3>
        <p class="text-ctc-blue font-medium text-sm mt-0.5">{{ $title }}</p>
        @if($specialization)
            <p class="text-gray-500 text-sm mt-1">{{ $specialization }}</p>
        @endif
        @if($bioPlain)
            <p class="mt-3 text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $bioPlain }}</p>
        @endif

        <div class="mt-5 inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.18em] text-ctc-blue/70 group-hover:text-ctc-blue transition-colors">
            <span>View profile</span>
            <svg class="w-4 h-4 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
        </div>
    </div>
</{{ $tag }}>

@props([
    'items' => [],
])

@if(is_array($items) && count($items) > 1)
    <nav aria-label="Breadcrumb" class="mt-6">
        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm font-semibold text-white/85">
            @foreach($items as $i => $item)
                @php
                    $isLast = $i === count($items) - 1;
                    $label = $item['label'] ?? '';
                    $url = $item['url'] ?? null;
                @endphp
                <li class="inline-flex items-center gap-2">
                    @if(!$isLast && $url)
                        <a href="{{ $url }}" class="hover:text-white transition-colors underline decoration-white/20 hover:decoration-ctc-ruby/80 underline-offset-4">
                            {{ $label }}
                        </a>
                        <span class="text-white/40" aria-hidden="true">/</span>
                    @else
                        <span class="text-white/95" aria-current="page">{{ $label }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif


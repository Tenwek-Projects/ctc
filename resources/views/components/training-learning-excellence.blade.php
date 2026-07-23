@props([
    'accent' => 'ruby',
])

@php
    $benefits = [
        'Consultant-led teaching and mentorship',
        'Hands-on clinical experience',
        'High surgical and procedural volumes',
        'Multidisciplinary learning',
        'Simulation and skills development',
        'Research and academic opportunities',
        'Continuing Medical Education (CME)',
        'International collaboration and professional exchange',
    ];

    $isRuby = $accent === 'ruby';
    $kickerClass = $isRuby ? 'text-ctc-ruby' : 'text-ctc-accent';
    $dotClass = $isRuby
        ? 'bg-ctc-ruby shadow-[0_0_0_4px_rgba(179,49,39,0.18)]'
        : 'bg-ctc-accent shadow-[0_0_0_4px_rgba(158, 196, 248,0.18)]';
@endphp

<section class="py-16 lg:py-20 bg-ctc-grey-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-gray-100 bg-ctc-blue px-6 py-8 sm:px-10 sm:py-10">
                    <p class="text-[11px] font-bold uppercase tracking-[0.22em] {{ $kickerClass }}">Trainee experience</p>
                    <h2 class="mt-3 text-2xl sm:text-3xl font-headline font-extrabold tracking-tight text-white">
                        Learning through excellence
                    </h2>
                    <p class="mt-3 max-w-2xl text-sm sm:text-base text-white/75 leading-relaxed">
                        Our trainees benefit from a learning environment built around mentorship, volume, and multidisciplinary practice.
                    </p>
                </div>

                <div class="p-6 sm:p-10">
                    <ul class="grid sm:grid-cols-2 gap-x-8 gap-y-4">
                        @foreach($benefits as $benefit)
                            <li class="flex items-start gap-3 text-gray-700 leading-relaxed">
                                <span class="mt-2 h-2 w-2 shrink-0 rounded-full {{ $dotClass }}" aria-hidden="true"></span>
                                <span>{{ $benefit }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

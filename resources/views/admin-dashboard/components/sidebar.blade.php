@php
    $menu = config('admin.menu', []);
@endphp
<nav class="mt-4 px-3 overflow-y-auto h-full pb-24">
    @php
        $visibleMenu = collect($menu)->filter(function ($item) {
            $permission = $item['permission'] ?? null;
            return !$permission || auth()->user()->hasPermission($permission);
        })->values();

        $groups = $visibleMenu->groupBy(function ($item) {
            return $item['group'] ?? 'Other';
        });

        $groupOrder = [
            'Overview',
            'Homepage',
            'About',
            'Departments',
            'Content',
            'Operations',
            'People',
            'Administration',
            'Other',
        ];

        $orderedGroups = collect($groupOrder)->filter(fn ($g) => $groups->has($g))
            ->mapWithKeys(fn ($g) => [$g => $groups->get($g)]);
    @endphp

    @foreach($orderedGroups as $groupLabel => $items)
        <div class="mt-4 first:mt-0">
            <p class="px-3 pb-2 text-[0.62rem] font-extrabold uppercase tracking-[0.22em] text-white/55">
                {{ $groupLabel }}
            </p>
            <div class="space-y-0.5">
                @foreach($items as $item)
                    @php
                        $routeBase = \Illuminate\Support\Str::beforeLast($item['route'], '.');
                        $active = request()->routeIs($item['route']) || request()->routeIs($routeBase . '.*');
                        $hash = $item['hash'] ?? null;
                        $href = route($item['route']) . ($hash ? ('#' . ltrim($hash, '#')) : '');
                    @endphp
                    <a href="{{ $href }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] leading-5 text-white/90 hover:bg-white/10 hover:text-white transition-colors {{ $active ? 'bg-white/15 text-white font-medium' : '' }}">
                        @include('admin-dashboard.components.icon', ['name' => $item['icon']])
                        <span class="truncate">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>
<div class="absolute bottom-0 left-0 right-0 p-3 border-t border-white/10 bg-admin-sidebar">
    <a href="{{ url('/') }}" target="_blank" rel="noopener" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-white/80 hover:bg-white/10 hover:text-white text-sm transition-colors">
        @include('admin-dashboard.components.icon', ['name' => 'external-link'])
        View site
    </a>
</div>

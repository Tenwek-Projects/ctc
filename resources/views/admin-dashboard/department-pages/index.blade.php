@extends('admin-dashboard.layouts.app')
@section('title', 'Departments')
@section('header', 'Departments')

@section('content')
    <div class="max-w-4xl space-y-6">
        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm p-6">
            <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-admin-muted">Public site</p>
            <h2 class="mt-2 text-xl font-semibold text-admin-dark">Department pages</h2>
            <p class="mt-1 text-sm text-admin-muted">
                Edit long-form department content such as
                <code class="text-xs bg-admin-bg px-1 rounded">/departments/cardiology</code>,
                <code class="text-xs bg-admin-bg px-1 rounded">/departments/cardiothoracic-surgery</code>, and
                <code class="text-xs bg-admin-bg px-1 rounded">/departments/endoscopy</code>.
                These pages are SEO-optimized with editable meta title, description, and article content.
            </p>
        </div>

        <div class="rounded-xl bg-admin-surface border border-gray-200 shadow-sm overflow-hidden">
            <ul class="divide-y divide-gray-100">
                @forelse($pages as $page)
                    <li class="flex flex-wrap items-center justify-between gap-4 p-5 hover:bg-admin-bg/60 transition-colors">
                        <div class="min-w-0">
                            <p class="font-semibold text-admin-dark">{{ $page->admin_label }}</p>
                            <p class="text-sm text-admin-muted mt-0.5 truncate">{{ $page->intro_heading }}</p>
                            <p class="mt-1 text-xs {{ $page->is_visible ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $page->is_visible ? 'Visible' : 'Hidden' }} · /departments/{{ $page->url_segment }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('departments.show', $page) }}"
                               target="_blank" rel="noopener"
                               class="px-3 py-2 rounded-lg border border-gray-300 text-sm text-admin-dark hover:bg-white">
                                View live
                            </a>
                            <a href="{{ route('admin-dashboard.department-pages.edit', $page) }}"
                               class="px-3 py-2 rounded-lg bg-admin-teal text-white text-sm font-medium hover:bg-admin-teal-dark">
                                Edit
                            </a>
                        </div>
                    </li>
                @empty
                    <li class="p-8 text-center text-sm text-admin-muted">
                        No department pages yet. Run <code class="text-xs bg-admin-bg px-1 rounded">php artisan db:seed --class=DepartmentPageSeeder</code>.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

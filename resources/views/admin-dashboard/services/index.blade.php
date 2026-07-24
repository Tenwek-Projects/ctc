@extends('admin-dashboard.layouts.app')

@section('title', 'Services')
@section('header', 'Services')

@section('content')
    <div class="mb-4 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-600 shadow-sm sm:px-6">
        Drag rows within each category to set order on the Services page and homepage. Use the homepage toggle to choose which services appear in the homepage preview.
    </div>

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            <div>
                <p class="text-sm text-gray-600">{{ $services->count() }} service(s)</p>
                <p class="mt-0.5 text-xs text-gray-500">
                    {{ $services->where('show_on_homepage', true)->count() }} selected for homepage
                </p>
            </div>
            <a href="{{ route('admin-dashboard.services.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
                Add service
            </a>
        </div>

        @forelse($grouped as $categoryKey => $group)
            <div @class(['border-t border-gray-200' => ! $loop->first])>
                <div class="bg-gray-50 px-4 py-2.5 sm:px-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $group['label'] }}</p>
                    <p class="mt-0.5 text-xs text-gray-400">{{ $group['services']->count() }} {{ \Illuminate\Support\Str::plural('service', $group['services']->count()) }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="admin-table min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left w-12"></th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Visible</th>
                                <th class="text-left">Homepage</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white"
                            @if($categoryKey !== '_other')
                                x-data="{
                                    category: @js($categoryKey),
                                    reorderUrl: @js(route('admin-dashboard.services.reorder')),
                                    csrf: @js(csrf_token()),
                                    draggingId: null,
                                    saving: false,
                                    onDragStart(event) {
                                        if (event.target.closest('a, button, input, form, label')) {
                                            event.preventDefault();
                                            return;
                                        }
                                        const row = event.target.closest('tr[data-service-id]');
                                        if (!row) return;
                                        this.draggingId = Number(row.dataset.serviceId);
                                        event.dataTransfer.effectAllowed = 'move';
                                        event.dataTransfer.setData('text/plain', String(this.draggingId));
                                    },
                                    onDragOver(event) {
                                        const row = event.target.closest('tr[data-service-id]');
                                        if (!row || this.draggingId === null) return;
                                        const dragging = this.$el.querySelector('tr[data-service-id=\'' + this.draggingId + '\']');
                                        if (!dragging || dragging === row) return;
                                        const rect = row.getBoundingClientRect();
                                        const after = (event.clientY - rect.top) > (rect.height / 2);
                                        if (after) row.after(dragging);
                                        else row.before(dragging);
                                    },
                                    async persistOrder() {
                                        if (this.saving) return;
                                        const order = [...this.$el.querySelectorAll('tr[data-service-id]')].map((row) => Number(row.dataset.serviceId));
                                        this.saving = true;
                                        try {
                                            const response = await fetch(this.reorderUrl, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': this.csrf,
                                                    'X-HTTP-Method-Override': 'PATCH',
                                                    'X-Requested-With': 'XMLHttpRequest',
                                                },
                                                body: JSON.stringify({ category: this.category, order }),
                                            });
                                            if (!response.ok) window.location.reload();
                                        } catch (e) {
                                            window.location.reload();
                                        } finally {
                                            this.saving = false;
                                        }
                                    },
                                    async onDrop() {
                                        await this.persistOrder();
                                    },
                                    async onDragEnd() {
                                        this.draggingId = null;
                                        await this.persistOrder();
                                    },
                                }"
                                @dragover.prevent="onDragOver($event)"
                                @drop.prevent="onDrop()"
                            @endif
                        >
                            @foreach($group['services'] as $service)
                                <tr
                                    data-service-id="{{ $service->id }}"
                                    @if($categoryKey !== '_other')
                                        draggable="true"
                                        @dragstart="onDragStart($event)"
                                        @dragend="onDragEnd()"
                                        class="cursor-grab active:cursor-grabbing"
                                        :class="{ 'opacity-50 bg-admin-bg/60': draggingId === {{ $service->id }} }"
                                    @endif
                                >
                                    <td class="align-middle text-gray-400">
                                        @if($categoryKey !== '_other')
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white" title="Drag to reorder" aria-hidden="true">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM8 21a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm8-15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM16 21a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-sm font-medium text-gray-900">{{ $service->name }}</td>
                                    <td class="text-sm">
                                        @if($service->is_visible)
                                            <span class="text-green-600">Yes</span>
                                        @else
                                            <span class="text-gray-400">No</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('admin-dashboard.services.homepage', ['service' => $service->id], false) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                role="switch"
                                                aria-checked="{{ $service->show_on_homepage ? 'true' : 'false' }}"
                                                aria-label="Show {{ $service->name }} on homepage"
                                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-admin-teal focus-visible:ring-offset-2 {{ $service->show_on_homepage ? 'bg-admin-teal' : 'bg-gray-300' }}"
                                            >
                                                <span
                                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition {{ $service->show_on_homepage ? 'translate-x-5' : 'translate-x-0' }}"
                                                ></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-right text-sm">
                                        <a href="{{ route('admin-dashboard.services.edit', $service) }}" class="text-admin-teal hover:underline mr-3">Edit</a>
                                        <form action="{{ route('admin-dashboard.services.destroy', $service) }}" method="post" class="inline" onsubmit="return confirm('Delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="px-4 py-10 text-center text-sm text-gray-500 sm:px-6">
                No services yet. <a href="{{ route('admin-dashboard.services.create') }}" class="text-admin-teal hover:underline">Add one</a>.
            </div>
        @endforelse
    </div>
@endsection

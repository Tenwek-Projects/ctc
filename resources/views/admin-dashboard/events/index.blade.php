@extends('admin-dashboard.layouts.app')

@section('title', 'Events')
@section('header', 'Events')

@section('content')
    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            <p class="text-sm text-gray-600">{{ $events->total() }} event(s)</p>
            <a href="{{ route('admin-dashboard.events.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
                Add event
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left">Title</th>
                        <th class="text-left">Event date</th>
                        <th class="text-left">Published</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($events as $event)
                        <tr>
                            <td class="text-sm font-medium text-gray-900">{{ $event->title }}</td>
                            <td class="text-sm text-gray-600">{{ optional($event->event_date)->format('M j, Y g:i A') ?: '-' }}</td>
                            <td class="text-sm">
                                @if($event->is_published)<span class="text-green-600">Yes</span>@else<span class="text-gray-400">No</span>@endif
                                @if($event->published_at) <span class="text-gray-400">({{ $event->published_at->format('M j, Y') }})</span>@endif
                            </td>
                            <td class="text-right text-sm">
                                <a href="{{ route('admin-dashboard.events.edit', $event) }}" class="text-admin-teal hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin-dashboard.events.destroy', $event) }}" method="post" class="inline" onsubmit="return confirm('Delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-10">No events yet. <a href="{{ route('admin-dashboard.events.create') }}" class="text-admin-teal hover:underline">Add one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $events->links() }}
            </div>
        @endif
    </div>
@endsection


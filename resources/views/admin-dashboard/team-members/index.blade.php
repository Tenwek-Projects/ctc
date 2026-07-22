@extends('admin-dashboard.layouts.app')

@section('title', 'Team')
@section('header', 'Team members')

@section('content')
    @if($errors->any())
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800 shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="rounded-xl bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3 sm:px-6">
            <div>
                <p class="text-sm text-gray-600">{{ $members->count() }} member(s)</p>
                <p class="mt-0.5 text-xs text-gray-500">
                    {{ $members->where('show_on_homepage', true)->count() }} selected for homepage
                </p>
            </div>
            <a href="{{ route('admin-dashboard.team-members.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg font-medium bg-admin-teal text-white hover:bg-admin-teal-dark text-sm">
                Add member
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table min-w-full">
                <thead>
                    <tr>
                        <th class="text-left">Photo</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Credentials</th>
                        <th class="text-left">Title</th>
                        <th class="text-left">Group</th>
                        <th class="text-left">Visible</th>
                        <th class="text-left">Homepage</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($members as $member)
                        <tr>
                            <td class="align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                        @if($member->photo_url)
                                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="h-full w-full object-cover object-top">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-gray-400">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('admin-dashboard.team-members.photo', ['team_member' => $member->id], false) }}"
                                          method="post"
                                          enctype="multipart/form-data"
                                          class="inline-flex">
                                        @csrf
                                        <label class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                            </svg>
                                            {{ $member->photo_url ? 'Replace' : 'Upload' }}
                                            <input
                                                type="file"
                                                name="photo"
                                                accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif"
                                                class="sr-only"
                                                onchange="this.form.submit()"
                                            >
                                        </label>
                                    </form>
                                </div>
                            </td>
                            <td class="text-sm font-medium text-gray-900">{{ $member->name }}</td>
                            <td class="text-sm text-gray-600">{{ $member->credentials ?: '—' }}</td>
                            <td class="text-sm text-gray-600">{{ $member->title }}</td>
                            <td class="text-sm text-gray-600">{{ $member->team_group_label ?: '—' }}</td>
                            <td class="text-sm">
                                @if($member->is_visible)
                                    <span class="text-green-600">Yes</span>
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('admin-dashboard.team-members.homepage', ['team_member' => $member->id], false) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        role="switch"
                                        aria-checked="{{ $member->show_on_homepage ? 'true' : 'false' }}"
                                        aria-label="Show {{ $member->name }} on homepage"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-admin-teal focus-visible:ring-offset-2 {{ $member->show_on_homepage ? 'bg-admin-teal' : 'bg-gray-300' }}"
                                    >
                                        <span
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow transition {{ $member->show_on_homepage ? 'translate-x-5' : 'translate-x-0' }}"
                                        ></span>
                                    </button>
                                </form>
                            </td>
                            <td class="text-right text-sm">
                                <a href="{{ route('admin-dashboard.team-members.edit', $member) }}" class="text-admin-teal hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin-dashboard.team-members.destroy', $member) }}" method="post" class="inline" onsubmit="return confirm('Delete this team member?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-10">No team members yet. <a href="{{ route('admin-dashboard.team-members.create') }}" class="text-admin-teal hover:underline">Add one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

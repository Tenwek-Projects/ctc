@extends('admin-dashboard.layouts.app')

@section('title', 'College Applications')
@section('header', 'College Applications')

@section('content')
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <form method="get" class="grid gap-3 md:grid-cols-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name, number, ID, phone, email" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <select name="intake_id" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                <option value="">All intakes</option>
                @foreach($intakes as $intake)
                    <option value="{{ $intake->id }}" @selected((string) request('intake_id') === (string) $intake->id)>{{ $intake->intake_name }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-admin-teal px-3 py-2 text-sm font-semibold text-white">Filter</button>
        </form>
    </div>

    <x-admin-dashboard.table-wrap class="mt-4">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Application #</th>
                    <th>Name</th>
                    <th>Intake</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>{{ $app->application_number ?? 'Draft' }}</td>
                        <td>{{ $app->personalDetail?->full_legal_name ?? 'N/A' }}</td>
                        <td>{{ $app->intake?->intake_name ?? 'N/A' }}</td>
                        <td>{{ str($app->status)->replace('_', ' ')->title() }}</td>
                        <td>{{ optional($app->submitted_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td><a href="{{ route('admin-dashboard.college-applications.show', $app) }}" class="text-admin-teal hover:underline">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6">No applications found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </x-admin-dashboard.table-wrap>

    <div class="mt-4">{{ $applications->links() }}</div>
@endsection


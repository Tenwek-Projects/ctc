@extends('admin-dashboard.layouts.app')

@section('title', 'Application Details')
@section('header', 'Application Details')

@section('content')
    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-admin-dark">Applicant</h2>
                <dl class="mt-3 grid gap-2 sm:grid-cols-2 text-sm">
                    <div><dt class="text-admin-muted">Application #</dt><dd class="font-semibold">{{ $application->application_number ?? 'Draft' }}</dd></div>
                    <div><dt class="text-admin-muted">Status</dt><dd class="font-semibold">{{ str($application->status)->replace('_', ' ')->title() }}</dd></div>
                    <div><dt class="text-admin-muted">Full name</dt><dd>{{ $application->personalDetail?->full_legal_name ?? 'N/A' }}</dd></div>
                    <div><dt class="text-admin-muted">Email</dt><dd>{{ $application->personalDetail?->email ?? 'N/A' }}</dd></div>
                    <div><dt class="text-admin-muted">Phone</dt><dd>{{ $application->personalDetail?->primary_mobile_number ?? 'N/A' }}</dd></div>
                    <div><dt class="text-admin-muted">National ID</dt><dd>{{ $application->personalDetail?->national_id_number ?? 'N/A' }}</dd></div>
                </dl>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-admin-dark">Documents</h2>
                <div class="mt-3 space-y-2">
                    @forelse($application->documents as $document)
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            <div>
                                <p class="font-medium">{{ str($document->document_type)->replace('_', ' ')->title() }}</p>
                                <p class="text-admin-muted">{{ $document->original_filename }} · {{ number_format($document->file_size / 1024, 1) }} KB</p>
                            </div>
                            <span class="rounded-full bg-admin-bg px-2 py-1 text-xs">{{ str($document->status)->replace('_', ' ')->title() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-admin-muted">No documents uploaded.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-semibold text-admin-dark">Update Status</h2>
                <form method="post" action="{{ route('admin-dashboard.college-applications.status', $application) }}" class="mt-3 space-y-3">
                    @csrf
                    @method('put')
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach([
                            'draft','submitted','under_review','incomplete','awaiting_documents','payment_pending_verification','eligible','shortlisted','interview_invited','interview_completed','admitted','waitlisted','unsuccessful','withdrawn'
                        ] as $status)
                            <option value="{{ $status }}" @selected($application->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <textarea name="notes" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Internal note"></textarea>
                    <button class="w-full rounded-lg bg-admin-teal px-4 py-2 text-sm font-semibold text-white">Save status</button>
                </form>
            </div>
        </div>
    </div>
@endsection


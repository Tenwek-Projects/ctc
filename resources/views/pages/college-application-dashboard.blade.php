@extends('layouts.app')

@section('title', 'Applicant Dashboard')

@section('content')
    <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-extrabold text-ctc-blue">Applicant Dashboard</h1>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4"><p class="text-xs uppercase text-gray-500">Application #</p><p class="mt-1 font-semibold text-ctc-blue">{{ $application->application_number ?? 'Not assigned' }}</p></div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4"><p class="text-xs uppercase text-gray-500">Status</p><p class="mt-1 font-semibold text-gray-900">{{ str($application->status)->replace('_', ' ')->title() }}</p></div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4"><p class="text-xs uppercase text-gray-500">Payment</p><p class="mt-1 font-semibold text-gray-900">{{ str($application->payment_verification_status)->replace('_', ' ')->title() }}</p></div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4"><p class="text-xs uppercase text-gray-500">Documents</p><p class="mt-1 font-semibold text-gray-900">{{ str($application->document_completeness_status)->replace('_', ' ')->title() }}</p></div>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('college.apply.show', ['application' => $application->uuid, 'token' => request('token')]) }}" class="inline-flex rounded-lg border border-ctc-secondary px-4 py-2 text-sm font-semibold text-ctc-secondary">Open Application</a>
            </div>
        </div>
    </section>
@endsection


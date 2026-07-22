@extends('layouts.app')

@section('title', 'Application Submitted')

@section('content')
    <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl rounded-2xl border border-green-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-extrabold text-ctc-blue">Application Submitted Successfully</h1>
            <p class="mt-3 text-gray-700">
                Your application has been received successfully. This acknowledgement does not constitute an offer of admission.
                Only shortlisted applicants will be contacted using the mobile number and email address provided.
            </p>
            <div class="mt-6 rounded-xl border border-gray-200 bg-gray-50 p-4">
                <p class="text-sm text-gray-600">Application Number</p>
                <p class="text-lg font-bold text-ctc-blue">{{ $application->application_number ?? 'Pending generation' }}</p>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('college.apply.dashboard', ['application' => $application->uuid, 'token' => request('token')]) }}" class="inline-flex rounded-lg bg-ctc-blue px-4 py-2 text-sm font-semibold text-white">Open Applicant Dashboard</a>
                <a href="{{ route('college.apply.show', ['application' => $application->uuid, 'token' => request('token')]) }}" class="inline-flex rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">View Application</a>
            </div>
        </div>
    </section>
@endsection


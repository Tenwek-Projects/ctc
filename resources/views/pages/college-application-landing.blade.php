@extends('layouts.app')

@section('title', 'College Application')

@section('content')
    <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-2xl font-extrabold text-ctc-blue">Application for Higher Diploma in Cardiovascular Perfusion</h1>
            <p class="mt-3 text-gray-700">Tenwek Hospital College – School of Health Sciences is receiving applications for the two-year Higher Diploma in Cardiovascular Perfusion programme.</p>
            <div class="mt-6 grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3"><p class="text-gray-600">Programme duration</p><p class="font-semibold">{{ $intake?->programme_duration ?? '2 years' }}</p></div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3"><p class="text-gray-600">Application deadline</p><p class="font-semibold">{{ optional($intake?->deadline_date)->format('d M Y') ?? '30 June' }}</p></div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3"><p class="text-gray-600">Application fee</p><p class="font-semibold">KES {{ number_format((int) ($intake?->application_fee_kes ?? 1500)) }}</p></div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3"><p class="text-gray-600">Estimated programme cost</p><p class="font-semibold">KES {{ number_format((int) ($intake?->estimated_programme_cost_kes ?? 700000)) }}</p></div>
            </div>
            <form method="post" action="{{ route('college.apply.start') }}" class="mt-8">
                @csrf
                <button class="inline-flex rounded-lg bg-ctc-blue px-5 py-3 text-sm font-semibold text-white">Start Online Application</button>
            </form>
        </div>
    </section>
@endsection


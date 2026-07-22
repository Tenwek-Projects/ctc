<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollegeApplication;
use App\Models\ProgrammeIntake;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegeApplicationAdminController extends Controller
{
    public function index(Request $request): View
    {
        $query = CollegeApplication::query()
            ->with(['programme', 'intake', 'personalDetail'])
            ->latest();

        if ($request->filled('intake_id')) {
            $query->where('programme_intake_id', (int) $request->input('intake_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', (string) $request->input('status'));
        }
        if ($request->filled('q')) {
            $q = trim((string) $request->input('q'));
            $query->where(function ($inner) use ($q): void {
                $inner->where('application_number', 'like', "%{$q}%")
                    ->orWhereHas('personalDetail', function ($p) use ($q): void {
                        $p->where('full_legal_name', 'like', "%{$q}%")
                            ->orWhere('national_id_number', 'like', "%{$q}%")
                            ->orWhere('primary_mobile_number', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        return view('admin-dashboard/college-applications/index', [
            'applications' => $query->paginate(20)->withQueryString(),
            'intakes' => ProgrammeIntake::query()->orderByDesc('opening_date')->get(['id', 'intake_name']),
            'statuses' => [
                CollegeApplication::STATUS_DRAFT,
                CollegeApplication::STATUS_SUBMITTED,
                CollegeApplication::STATUS_UNDER_REVIEW,
                CollegeApplication::STATUS_INCOMPLETE,
                CollegeApplication::STATUS_AWAITING_DOCUMENTS,
                CollegeApplication::STATUS_PAYMENT_PENDING_VERIFICATION,
                CollegeApplication::STATUS_ELIGIBLE,
                CollegeApplication::STATUS_SHORTLISTED,
                CollegeApplication::STATUS_INTERVIEW_INVITED,
                CollegeApplication::STATUS_INTERVIEW_COMPLETED,
                CollegeApplication::STATUS_ADMITTED,
                CollegeApplication::STATUS_WAITLISTED,
                CollegeApplication::STATUS_UNSUCCESSFUL,
                CollegeApplication::STATUS_WITHDRAWN,
            ],
        ]);
    }

    public function show(CollegeApplication $collegeApplication): View
    {
        $collegeApplication->load([
            'programme',
            'intake',
            'personalDetail',
            'documents',
            'payment',
            'declaration',
            'statusHistory',
        ]);

        return view('admin-dashboard/college-applications/show', [
            'application' => $collegeApplication,
        ]);
    }

    public function updateStatus(Request $request, CollegeApplication $collegeApplication): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'max:60'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $from = $collegeApplication->status;
        $to = (string) $request->input('status');
        $collegeApplication->update(['status' => $to]);
        $collegeApplication->statusHistory()->create([
            'from_status' => $from,
            'to_status' => $to,
            'notes' => (string) $request->input('notes', ''),
            'changed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Application status updated.');
    }
}


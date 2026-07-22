<?php

namespace Tests\Feature;

use App\Models\CollegeApplication;
use App\Models\Programme;
use App\Models\ProgrammeIntake;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CollegeApplicationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_applicant_can_start_and_save_draft(): void
    {
        $programme = Programme::query()->create([
            'code' => 'THC-SHS-CP',
            'name' => 'Higher Diploma in Cardiovascular/Cardiac Perfusion Clinical Medicine',
            'is_active' => true,
        ]);
        $intake = ProgrammeIntake::query()->create([
            'programme_id' => $programme->id,
            'intake_name' => 'Current Intake',
            'status' => 'open',
        ]);

        $this->post(route('college.apply.start'))->assertRedirect();
        $app = CollegeApplication::query()->firstOrFail();

        $this->postJson(route('college.apply.save-draft', ['application' => $app->uuid, 'token' => $app->access_token]), [
            'step' => 2,
            'data' => [
                'personal' => [
                    'full_legal_name' => 'Jane Applicant',
                    'primary_mobile_number' => '0728000000',
                    'email' => 'jane@example.com',
                ],
            ],
            'programme_intake_id' => $intake->id,
        ])->assertOk();

        $this->assertNotNull($app->fresh()->draft_payload);
    }

    public function test_document_upload_requires_valid_token(): void
    {
        $programme = Programme::query()->create([
            'code' => 'THC-SHS-CP',
            'name' => 'Higher Diploma in Cardiovascular/Cardiac Perfusion Clinical Medicine',
            'is_active' => true,
        ]);
        $app = CollegeApplication::query()->create([
            'programme_id' => $programme->id,
            'status' => CollegeApplication::STATUS_DRAFT,
        ]);

        $this->post(route('college.apply.upload-document', ['application' => $app->uuid, 'token' => 'invalid']), [
            'document_type' => 'kcse_certificate',
            'document' => UploadedFile::fake()->image('certificate.png'),
        ])->assertForbidden();
    }

    public function test_admin_college_applications_route_requires_authentication(): void
    {
        $this->get(route('admin-dashboard.college-applications.index'))->assertRedirect(route('login'));
    }
}


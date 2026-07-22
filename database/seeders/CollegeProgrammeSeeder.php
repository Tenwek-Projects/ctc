<?php

namespace Database\Seeders;

use App\Models\Programme;
use App\Models\ProgrammeIntake;
use Illuminate\Database\Seeder;

class CollegeProgrammeSeeder extends Seeder
{
    public function run(): void
    {
        $programme = Programme::query()->updateOrCreate(
            ['code' => 'THC-SHS-CP'],
            [
                'name' => 'Higher Diploma in Cardiovascular/Cardiac Perfusion Clinical Medicine',
                'school_name' => 'School of Health Sciences',
                'description' => 'Two-year Higher Diploma in Cardiovascular Perfusion.',
                'is_active' => true,
            ]
        );

        ProgrammeIntake::query()->updateOrCreate(
            ['programme_id' => $programme->id, 'intake_name' => 'Current Intake'],
            [
                'opening_date' => now()->startOfMonth()->toDateString(),
                'deadline_date' => now()->month(6)->day(30)->toDateString(),
                'expected_intake_date' => now()->addMonths(3)->startOfMonth()->toDateString(),
                'interview_period' => 'After application close',
                'interview_communication_method' => 'SMS',
                'programme_duration' => '2 years',
                'application_fee_kes' => 1500,
                'estimated_programme_cost_kes' => 700000,
                'deposit_amount_kes' => 250000,
                'status' => 'open',
                'max_applicants' => 300,
                'additional_instructions' => 'Only shortlisted candidates will be contacted.',
            ]
        );
    }
}


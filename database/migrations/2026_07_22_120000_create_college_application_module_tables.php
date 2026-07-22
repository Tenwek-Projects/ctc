<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('school_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('programme_intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programme_id')->constrained()->cascadeOnDelete();
            $table->string('intake_name');
            $table->date('opening_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->date('expected_intake_date')->nullable();
            $table->string('interview_period')->nullable();
            $table->string('interview_communication_method')->default('SMS');
            $table->string('programme_duration')->default('2 years');
            $table->unsignedBigInteger('application_fee_kes')->default(1500);
            $table->unsignedBigInteger('estimated_programme_cost_kes')->default(700000);
            $table->unsignedBigInteger('deposit_amount_kes')->default(250000);
            $table->unsignedInteger('max_applicants')->nullable();
            $table->string('status')->default('open')->index();
            $table->text('additional_instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('college_applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('access_token', 120)->unique();
            $table->string('application_number')->nullable()->unique();
            $table->foreignId('programme_id')->constrained()->restrictOnDelete();
            $table->foreignId('programme_intake_id')->nullable()->constrained('programme_intakes')->nullOnDelete();
            $table->string('status')->default('draft')->index();
            $table->string('payment_verification_status')->default('pending')->index();
            $table->string('document_completeness_status')->default('incomplete')->index();
            $table->string('reference_status')->default('pending')->index();
            $table->string('interview_status')->default('pending')->index();
            $table->unsignedTinyInteger('current_step')->default(1);
            $table->unsignedTinyInteger('completion_percent')->default(0);
            $table->json('draft_payload')->nullable();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->ipAddress('submission_ip')->nullable();
            $table->text('submission_user_agent')->nullable();
            $table->timestamp('last_autosaved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('applicant_personal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->date('application_date')->nullable();
            $table->string('full_legal_name');
            $table->string('national_id_number')->nullable()->index();
            $table->string('passport_number')->nullable()->index();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('town')->nullable();
            $table->string('county')->nullable()->index();
            $table->string('country_of_residence')->nullable();
            $table->string('primary_mobile_number');
            $table->string('alternative_mobile_number')->nullable();
            $table->string('email')->index();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('calculated_age')->nullable();
            $table->string('sex')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_address')->nullable();
            $table->string('spouse_occupation')->nullable();
            $table->string('spouse_mobile_number')->nullable();
            $table->unsignedTinyInteger('children_count')->nullable();
            $table->string('children_names_or_initials')->nullable();
            $table->string('children_ages')->nullable();
            $table->date('youngest_child_dob')->nullable();
            $table->string('photo_document_id')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_family_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('person_type')->index(); // father, mother, guardian
            $table->string('full_name');
            $table->boolean('is_living')->nullable();
            $table->string('occupation')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_church_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->string('church_name')->nullable();
            $table->string('denomination')->nullable();
            $table->string('church_location')->nullable();
            $table->string('church_county')->nullable();
            $table->string('pastor_name')->nullable();
            $table->string('pastor_mobile_number')->nullable();
            $table->string('membership_status')->nullable();
            $table->string('length_of_membership')->nullable();
            $table->text('areas_of_involvement')->nullable();
            $table->boolean('statement_of_faith_acknowledged')->default(false);
            $table->timestamps();
        });

        Schema::create('applicant_secondary_schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('school_name');
            $table->string('school_address')->nullable();
            $table->string('county_or_country')->nullable();
            $table->unsignedSmallInteger('start_year')->nullable();
            $table->unsignedSmallInteger('end_year')->nullable();
            $table->string('mean_grade_attained')->nullable();
            $table->string('examination_type')->nullable();
            $table->string('examination_index_number')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_higher_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('institution_name');
            $table->string('institution_address')->nullable();
            $table->string('county_or_country')->nullable();
            $table->string('course_programme')->nullable();
            $table->unsignedSmallInteger('start_year')->nullable();
            $table->unsignedSmallInteger('end_year')->nullable();
            $table->string('qualification_attained')->nullable();
            $table->string('awarding_institution')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('registration_number')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_professional_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->string('coc_licence_number')->nullable()->index();
            $table->date('licence_issue_date')->nullable();
            $table->date('licence_expiry_date')->nullable()->index();
            $table->string('licence_status')->nullable();
            $table->string('professional_registration_number')->nullable();
            $table->string('professional_title')->nullable();
            $table->unsignedTinyInteger('years_of_clinical_experience')->nullable();
            $table->text('areas_of_clinical_experience')->nullable();
            $table->string('current_practising_county')->nullable();
            $table->string('current_practising_facility')->nullable();
            $table->text('expired_licence_explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_current_employment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->string('employment_type')->nullable();
            $table->boolean('currently_employed')->default(true);
            $table->string('employer_name')->nullable();
            $table->string('facility_organisation')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('county')->nullable();
            $table->string('position_held')->nullable();
            $table->date('employment_start_date')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_mobile_number')->nullable();
            $table->string('supervisor_email')->nullable();
            $table->text('not_employed_explanation')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_employment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('employer_name')->nullable();
            $table->string('employer_address')->nullable();
            $table->string('position_held')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('duration_label')->nullable();
            $table->string('reason_for_leaving')->nullable();
            $table->string('supervisor_contact_person')->nullable();
            $table->string('contact_telephone_number')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_leadership_experience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('position_role')->nullable();
            $table->string('organisation')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('key_responsibilities')->nullable();
            $table->text('main_achievement')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('reference_type')->index(); // pastor, church_leader, long_term
            $table->string('full_name');
            $table->string('organisation')->nullable();
            $table->string('position')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('alternative_number')->nullable();
            $table->string('email')->nullable();
            $table->string('relationship_to_applicant')->nullable();
            $table->unsignedTinyInteger('years_known')->nullable();
            $table->boolean('is_relative')->default(false);
            $table->string('previous_workstation')->nullable();
            $table->string('reference_status')->default('pending')->index(); // request sent/opened/submitted/approved/rejected/pending
            $table->timestamp('request_sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_essays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->unsignedTinyInteger('question_number')->index();
            $table->text('question_text');
            $table->text('typed_transcription')->nullable();
            $table->string('paying_person_name')->nullable();
            $table->string('paying_person_relationship')->nullable();
            $table->string('source_of_income')->nullable();
            $table->string('estimated_income_range')->nullable();
            $table->string('sponsorship_status')->nullable();
            $table->text('financial_explanation')->nullable();
            $table->string('heard_about_source')->nullable();
            $table->timestamps();
            $table->unique(['college_application_id', 'question_number'], 'uniq_app_essay_question');
        });

        Schema::create('applicant_medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->text('family_hereditary_explanation')->nullable();
            $table->text('family_tb_explanation')->nullable();
            $table->text('hospital_admission_explanation')->nullable();
            $table->text('surgical_history_explanation')->nullable();
            $table->text('medication_explanation')->nullable();
            $table->text('allergies')->nullable();
            $table->text('disability_support_requirements')->nullable();
            $table->text('dietary_requirements')->nullable();
            $table->text('additional_health_information')->nullable();
            $table->string('pregnancy_status')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->text('requested_support')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_medical_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('condition_key')->index();
            $table->boolean('response')->nullable();
            $table->text('explanation')->nullable();
            $table->timestamps();
            $table->unique(['college_application_id', 'condition_key'], 'uniq_app_medical_condition');
        });

        Schema::create('applicant_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('document_type')->index();
            $table->string('status')->default('uploaded')->index(); // not_uploaded/uploaded/requires_replacement/verified/rejected
            $table->string('original_filename');
            $table->string('stored_filename');
            $table->string('storage_disk')->default('local');
            $table->string('storage_path');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('applicant_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->string('payment_method')->nullable();
            $table->unsignedBigInteger('amount_paid_kes')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('transaction_reference')->nullable()->index();
            $table->string('payer_name')->nullable();
            $table->string('payer_phone')->nullable();
            $table->string('applicant_name_in_narration')->nullable();
            $table->text('payment_notes')->nullable();
            $table->string('verification_status')->default('pending')->index();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('applicant_declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->boolean('declaration_truthfulness')->default(false);
            $table->boolean('declaration_no_withholding')->default(false);
            $table->boolean('consent_contact_referees')->default(false);
            $table->boolean('declaration_no_guarantee')->default(false);
            $table->boolean('declaration_non_refundable_fee')->default(false);
            $table->boolean('consent_data_processing')->default(false);
            $table->string('typed_legal_name')->nullable();
            $table->string('signature_type')->nullable();
            $table->text('signature_payload')->nullable();
            $table->date('declaration_date')->nullable();
            $table->timestamps();
        });

        Schema::create('application_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('review_date')->nullable();
            $table->text('internal_comments')->nullable();
            $table->text('missing_requirements')->nullable();
            $table->unsignedTinyInteger('eligibility_score')->nullable();
            $table->unsignedTinyInteger('interview_score')->nullable();
            $table->string('final_recommendation')->nullable();
            $table->string('admission_decision')->nullable()->index();
            $table->json('office_use_checklist')->nullable();
            $table->timestamps();
        });

        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status')->index();
            $table->text('notes')->nullable();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('application_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note');
            $table->boolean('is_internal')->default(true);
            $table->timestamps();
        });

        Schema::create('interview_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->constrained('college_applications')->cascadeOnDelete();
            $table->timestamp('scheduled_for')->nullable();
            $table->string('channel')->default('sms');
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('interview_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_application_id')->unique()->constrained('college_applications')->cascadeOnDelete();
            $table->timestamp('interviewed_at')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->string('recommendation')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_results');
        Schema::dropIfExists('interview_invitations');
        Schema::dropIfExists('application_notes');
        Schema::dropIfExists('application_status_histories');
        Schema::dropIfExists('application_reviews');
        Schema::dropIfExists('applicant_declarations');
        Schema::dropIfExists('applicant_payments');
        Schema::dropIfExists('applicant_documents');
        Schema::dropIfExists('applicant_medical_conditions');
        Schema::dropIfExists('applicant_medical_histories');
        Schema::dropIfExists('applicant_essays');
        Schema::dropIfExists('applicant_references');
        Schema::dropIfExists('applicant_leadership_experience');
        Schema::dropIfExists('applicant_employment_history');
        Schema::dropIfExists('applicant_current_employment');
        Schema::dropIfExists('applicant_professional_details');
        Schema::dropIfExists('applicant_higher_education');
        Schema::dropIfExists('applicant_secondary_schools');
        Schema::dropIfExists('applicant_church_details');
        Schema::dropIfExists('applicant_family_details');
        Schema::dropIfExists('applicant_personal_details');
        Schema::dropIfExists('college_applications');
        Schema::dropIfExists('programme_intakes');
        Schema::dropIfExists('programmes');
    }
};


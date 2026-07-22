<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCollegeApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'typed_legal_name' => ['required', 'string', 'max:255'],
            'declaration_truthfulness' => ['accepted'],
            'declaration_no_withholding' => ['accepted'],
            'consent_contact_referees' => ['accepted'],
            'declaration_no_guarantee' => ['accepted'],
            'declaration_non_refundable_fee' => ['accepted'],
            'consent_data_processing' => ['accepted'],
        ];
    }
}


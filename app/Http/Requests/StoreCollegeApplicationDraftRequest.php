<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollegeApplicationDraftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'step' => ['required', 'integer', 'min:1', 'max:12'],
            'current_step' => ['nullable', 'integer', 'min:1', 'max:12'],
            'programme_intake_id' => ['nullable', 'integer', 'exists:programme_intakes,id'],
            'data' => ['required', 'array'],
            'data.personal.full_legal_name' => ['nullable', 'string', 'max:255'],
            'data.personal.primary_mobile_number' => ['nullable', 'string', 'max:30'],
            'data.personal.email' => ['nullable', 'email', 'max:255'],
            'data.personal.date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'data.references' => ['nullable', 'array'],
            'data.payment.amount_paid_kes' => ['nullable', 'integer', 'min:0'],
        ];
    }
}


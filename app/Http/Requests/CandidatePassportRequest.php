<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CandidatePassportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'passport_type'           => ['required', Rule::in(['no_passport', 'ordinary', 'official', 'diplomatic', 'special'])],
            'passport_number'         => 'required|string|max:255',
            'passport_issue_date'     => 'required|date',
            'passport_expired_date'   => 'nullable|date',
            'passport_issue_place_id' => 'required|exists:districts,id',
            'validity_years'          => ['required', Rule::in([5, 10])],
            'passport_scan_copy'      => 'required|file',
            'note'                    => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'passport_type.required' => 'Passport type is required.',
            'passport_type.in' => 'Passport type must be one of: no_passport, ordinary, official, diplomatic, or special.',

            'passport_number.required' => 'Passport number is required.',
            'passport_number.string' => 'Passport number must be a string.',
            'passport_number.max' => 'Passport number may not be greater than 255 characters.',

            'passport_issue_date.required' => 'Passport issue date is required.',
            'passport_issue_date.date' => 'Passport issue date must be a valid date.',

            'passport_expired_date.date' => 'Passport expired date must be a valid date.',

            'passport_issue_place_id.required' => 'Passport issue place is required.',
            'passport_issue_place_id.exists' => 'Selected passport issue place is invalid.',

            'validity_years.required' => 'Validity years is required.',
            'validity_years.in' => 'Validity years must be either 5 or 10.',

            'passport_scan_copy.required' => 'Passport scan copy is required.',
            'passport_scan_copy.file' => 'Passport scan copy must be a valid file.',

            'note.string' => 'Note must be a string.',
        ];
    }
}

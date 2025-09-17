<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CandidateExperienceRequest extends FormRequest
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
        $rules = [
            'experience_type' => 'required|in:fresher,experienced',
        ];

        if ($this->experience_type === 'experienced') {
            $rules = array_merge($rules, [
                'company_name' => 'nullable|string|max:255',
                'work_type_id' => 'nullable|string',
                'departure_date' => 'required|date',
                'arrival_date' => 'required|date',
                'departure_seal' => 'required|file',
                'arrival_seal' => 'required|file',
                'travelled_country_id' => 'required|exists:countries,id',
                'old_company_address' => 'nullable|string',
            ]);
        } else {
            $rules = array_merge($rules, [
                'company_name' => 'nullable|string',
                'work_type_id' => 'nullable|string',
                'departure_date' => 'nullable|date',
                'arrival_date' => 'nullable|date',
                'departure_seal' => 'nullable|file',
                'arrival_seal' => 'nullable|file',
                'travelled_country_id' => 'nullable|exists:countries,id',
                'old_company_address' => 'nullable|string',
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'experience_type.required' => 'Experience type is required.',
            'experience_type.in' => 'Experience type must be either fresher or experienced.',
            'departure_date.required' => 'Departure date is required.',
            'departure_date.date' => 'Departure date must be a valid date.',
            'arrival_date.required' => 'Arrival date is required.',
            'arrival_date.date' => 'Arrival date must be a valid date.',
            'departure_seal.required' => 'Departure seal file is required.',
            'departure_seal.file' => 'Departure seal must be a valid file.',
            'arrival_seal.required' => 'Arrival seal file is required.',
            'arrival_seal.file' => 'Arrival seal must be a valid file.',
            'travelled_country_id.required' => 'Travelled country is required.',
            'travelled_country_id.exists' => 'Travelled country is invalid.',
        ];
    }
}

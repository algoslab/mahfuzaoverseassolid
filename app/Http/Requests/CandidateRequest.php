<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
            'candidate_type_id' => 'required|exists:candidate_types,id',
            'referral_agent_id' => 'required|exists:agents,id',
            'interested_country_id' => 'required|exists:countries,id',
            'interested_profession_id' => 'required|exists:professions,id',
            'nationality' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'candidate_type_id.required' => 'Candidate type is required.',
            'referral_agent_id.required' => 'Referral agent is required.',
            'interested_country_id.required' => 'Interested country is required.',
            'interested_profession_id.required' => 'Interested profession is required.',
            'nationality.required' => 'Nationality is required.',
        ];
    }
}

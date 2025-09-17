<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatePersonalInfoRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender_id' => 'required|exists:genders,id',
            'date_of_birth' => 'required|date',
            'email' => 'nullable|email',
            'phone_number' => 'required',
            'contact_person_number' => 'required',
            'nid_or_birth_certificate' => 'required',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'marital_status' => 'required',
            'spouse_name' => 'nullable|string|max:255',
            'nominee_name' => 'required|string|max:255',
            'relation_with_nominee_id' => 'required|exists:relations,id',
            'religion_id' => 'required|exists:religions,id',
            'blood_group_id' => 'required|exists:blood_groups,id',
            'note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'gender_id.required' => 'Gender is required.',
            'gender_id.exists' => 'Selected gender is invalid.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date' => 'Date of birth must be a valid date.',
            'email.email' => 'Please provide a valid email address.',
            'phone_number.required' => 'Phone number is required.',
            'contact_person_number.required' => 'Contact person number is required.',
            'nid_or_birth_certificate.required' => 'NID or Birth Certificate is required.',
            'father_name.required' => 'Father\'s name is required.',
            'mother_name.required' => 'Mother\'s name is required.',
            'marital_status.required' => 'Marital status is required.',
            'nominee_name.required' => 'Nominee name is required.',
            'relation_with_nominee_id.required' => 'Relation with nominee is required.',
            'relation_with_nominee_id.exists' => 'Invalid relation selected.',
            'religion_id.required' => 'Religion is required.',
            'religion_id.exists' => 'Invalid religion selected.',
            'blood_group_id.required' => 'Blood group is required.',
            'blood_group_id.exists' => 'Invalid blood group selected.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateLocationRequest extends FormRequest
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
            'country_id'        => 'required|exists:countries,id',
            'division_id'       => 'required|exists:divisions,id',
            'district_id'       => 'required|exists:districts,id',
            'thana_id'          => 'required|exists:thanas,id',
            'post_office_id'    => 'required|exists:post_offices,id',
            'state_id'          => 'nullable|exists:states,id',
            'current_address'   => 'nullable|string',
            'permanent_address' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required.',
            'country_id.exists' => 'Selected country is invalid.',

            'division_id.required' => 'Division is required.',
            'division_id.exists' => 'Selected division is invalid.',

            'district_id.required' => 'District is required.',
            'district_id.exists' => 'Selected district is invalid.',

            'thana_id.required' => 'Thana is required.',
            'thana_id.exists' => 'Selected thana is invalid.',

            'post_office_id.required' => 'Post office is required.',
            'post_office_id.exists' => 'Selected post office is invalid.',

            'state_id.exists' => 'Selected state is invalid.',

            'current_address.string' => 'Current address must be a string.',
            'permanent_address.string' => 'Permanent address must be a string.',
        ];
    }
}

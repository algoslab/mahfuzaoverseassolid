<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateFileRequest extends FormRequest
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
            'candidate_photo' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'police_verification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'other_certification' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'optional_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'candidate_photo.required' => 'Candidate photo is required.',
            'candidate_photo.file' => 'Candidate photo must be a valid file.',
            'candidate_photo.mimes' => 'Candidate photo must be a JPG, JPEG, PNG, or PDF file.',
            'candidate_photo.max' => 'Candidate photo must not exceed 2MB.',

            'police_verification.file' => 'Police verification must be a valid file.',
            'police_verification.mimes' => 'Police verification must be a JPG, JPEG, PNG, or PDF file.',
            'police_verification.max' => 'Police verification file must not exceed 2MB.',

            'other_certification.file' => 'Other certification must be a valid file.',
            'other_certification.mimes' => 'Other certification must be a JPG, JPEG, PNG, or PDF file.',
            'other_certification.max' => 'Other certification file must not exceed 2MB.',

            'optional_file.file' => 'Optional file must be a valid file.',
            'optional_file.mimes' => 'Optional file must be a JPG, JPEG, PNG, or PDF file.',
            'optional_file.max' => 'Optional file must not exceed 2MB.',
        ];
    }
}

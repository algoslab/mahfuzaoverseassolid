<div class="row">
    <div class="col-md-3">
        <div class="image_area">
            <form id="candidatePhotoForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

                <label for="candidate_photo_update" class="profile-image-wrapper">
                    <img 
                        src="{{ asset($candidate->files?->candidate_photo ?? 'backend/images/avatar/no-photo.jpg') }}"
                        alt="Candidate Image"
                        id="candidate_photo_preview" 
                        class="img-responsive img-thumbnail rounded-circle"
                        style="width: 250px; height: 250px; object-fit: cover;"
                    >
                    <div class="overlay">
                        Click to Change Profile Picture
                    </div>
                    <input 
                        type="file" 
                        name="candidate_photo" 
                        class="image" 
                        id="candidate_photo_update" 
                        accept="image/*" 
                        style="display: none;"
                    >
                </label>
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <b><u>Personal Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">First name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->first_name ?? '' }}</b></td>

                    <td style="width: 180px;">Last name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->last_name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Gender</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->gender?->name ?? '' }}</b></td>

                    <td style="width: 180px;">Date of birth</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            {{ $candidate->personalInfo?->date_of_birth 
                                ? \Carbon\Carbon::parse($candidate->personalInfo->date_of_birth)->format('d-m-Y') 
                                : '' 
                            }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 180px;">Email</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->email ?? '' }}</b></td>

                    <td style="width: 180px;">Phone number</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->phone_number ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Contact person number</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->contact_person_number ?? '' }}</b></td>

                    <td style="width: 180px;">NID / Birth certificate</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->nid_or_birth_certificate ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Father name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->father_name ?? '' }}</b></td>

                    <td style="width: 180px;">Mother name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->mother_name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Marital status</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->marital_status ?? '' }}</b></td>

                    <td style="width: 180px;">Spouse name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->spouse_name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Nominee name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->nominee_name ?? '' }}</b></td>

                    <td style="width: 180px;">Relation with nominee</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->nomineeRelation?->name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Religion</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->religion?->name ?? '' }}</b></td>

                    <td style="width: 180px;">Blood group</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->personalInfo?->bloodGroup?->name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Note</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4">
                        <b>{{ $candidate->personalInfo?->note ?? '' }}</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <b><u>Basic Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">Candidate Type</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4"><b>{{ $candidate->candidateType?->name ?? '' }}</b></td>									
                </tr>

                <tr>									
                    <td style="width: 180px;">Interested Country</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->country?->name ?? '' }}</b></td>

                    <td style="width: 180px;">Interested Job</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->profession?->name ?? '' }}</b></td>
                </tr>

                <tr>									
                    <td style="width: 180px;">Process Country</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->processCountry?->name ?? 'N/A' }}</b></td>

                    <td style="width: 180px;">Process Job</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->processProfession?->name ?? 'N/A' }}</b></td>
                </tr>

                <tr>
                    <td style="width: 180px;">Referral Agent</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->agent?->full_name ?? '' }}</b></td>

                    <td style="width: 180px;">Nationality</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->nationality ?? '' }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <b><u>Experience Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">Experience Type</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4"><b>{{ $candidate->experiences?->experience_type ?? '' }}</b></td>									
                </tr>

                <tr>									
                    <td style="width: 180px;">Company Name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->experiences?->company_name ?? '' }}</b></td>

                    <td style="width: 180px;">Work Type</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->experiences?->workType?->name ?? '' }}</b></td>
                </tr>

                <tr>									
                    <td style="width: 180px;">Departure Date</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            {{ $candidate->experiences?->departure_date 
                                ? \Carbon\Carbon::parse($candidate->experiences->departure_date)->format('d-m-Y') 
                                : '' 
                            }}
                        </b>
                    </td>

                    <td style="width: 180px;">Arrival Date</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            {{ $candidate->experiences?->arrival_date 
                                ? \Carbon\Carbon::parse($candidate->experiences->arrival_date)->format('d-m-Y') 
                                : '' 
                            }}
                        </b>
                    </td>
                </tr>

                <tr>
                    <td style="width: 180px;">Departure Seal</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->experiences->departure_seal ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>

                    <td style="width: 180px;">Arrival Seal</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->experiences->arrival_seal ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>
                </tr>

                <tr>
                    <td style="width: 180px;">Old Company Address</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4"><b>{{ $candidate->experiences?->old_company_address ?? '' }}</b></td>									
                </tr>

                <tr>
                    <td style="width: 180px;">Travelled Country</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4">
                        <b>
                            @php
                                $ids = $candidate->experiences?->travelled_country_id;
                                if (is_string($ids)) {
                                    $ids = json_decode($ids, true);
                                }
                                $names = [];
                                if (is_array($ids)) {
                                    foreach ($ids as $id) {
                                        $names[] = $countries[$id] ?? $id;
                                    }
                                }
                            @endphp
                            {{ !empty($names) ? implode(', ', $names) : '' }}
                        </b>
                    </td>									
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <b><u>Passport Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">Passport Number</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->passport?->passport_number ?? '' }}</b></td>
                    
                    <td style="width: 180px;">Passport Issue Date</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            {{ $candidate->passport?->passport_issue_date 
                                ? \Carbon\Carbon::parse($candidate->passport->passport_issue_date)->format('d-m-Y') 
                                : '' 
                            }}
                        </b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 180px;">Passport Issue Place</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->passport?->issuePlace?->name ?? '' }}</b></td>

                    <td style="width: 180px;">Validity Year</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->passport?->validity_years ?? '' }} years</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Passport Scan Copy</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->passport->passport_scan_copy ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>

                    <td style="width: 180px;">Note</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->passport?->note ?? '' }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <b class="d-block mb-2"><u>Location Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">Country</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->country?->name }}</b></td>
                    <td style="width: 180px;">Division</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->division?->name }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">District</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->district?->name }}</b></td>
                    <td style="width: 180px;">Thana</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->thana?->name }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Post Office</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->postOffice?->name }}</b></td>
                    <td style="width: 180px;">State</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $candidate->location?->state?->name }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Current Address</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4"><b>{{ $candidate->location?->current_address }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Permanent Address</td>
                    <td style="width: 10px;">:</td>
                    <td colspan="4"><b>{{ $candidate->location?->current_address }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <b><u>All Files & Documents:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>									
                    <td style="width: 180px;">Candidate Photo</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->files?->candidate_photo ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>									
                </tr>
                <tr>									
                    <td style="width: 180px;">Police Verification</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->files?->police_verification ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>									
                </tr>
                <tr>
                    <td style="width: 180px;">Other Certification</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->files?->other_certification ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>									
                </tr>
                <tr>
                    <td style="width: 180px;">Optional File/Files</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($candidate->files?->optional_file ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>									
                </tr>								
            </tbody>
        </table>
    </div>
</div>

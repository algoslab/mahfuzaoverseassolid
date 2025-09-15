@php
    // These arrays are passed from the controller
    $candidateTypes = $candidateTypes ?? [];
    $agents = $agents ?? [];
    $countries = $countries ?? [];
    $professions = $professions ?? [];
    $genders = $genders ?? [];
    $relations = $relations ?? [];
    $religions = $religions ?? [];
    $bloodGroups = $bloodGroups ?? [];
    $countries = $countries ?? [];
    $divisions = $divisions ?? [];
    $districts = $districts ?? [];
    $thanas = $thanas ?? [];
    $postOffices = $postOffices ?? [];
    $states = $states ?? [];
    $travelledCountries = $travelledCountries ?? [];
@endphp
<div class="mb-3">
    <h5>Review Your Information</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 6; $i++)
                    @foreach(session("form.step_$i", []) as $key => $value)
                        <tr>
                            <td>{{ ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $key))) }}</td>
                            <td>
                                @if($key === 'candidate_type_id')
                                    <b>{{ $candidateTypes[$value] ?? $value }}</b>
                                @elseif ($key === 'referral_agent_id')
                                    <b>{{ $agents[$value] ?? $value }}</b>
                                @elseif($key === 'interested_country_id')
                                    <b>{{ $countries[$value] ?? $value }}</b>
                                @elseif($key === 'interested_profession_id')
                                    <b>{{ $professions[$value] ?? $value }}</b>
                                @elseif($key === 'gender_id')
                                    <b>{{ $genders[$value] ?? $value }}</b>
                                @elseif($key === 'relation_with_nominee_id')
                                    <b>{{ $relations[$value] ?? $value }}</b>
                                @elseif($key === 'religion_id')
                                    <b>{{ $religions[$value] ?? $value }}</b>
                                @elseif($key === 'blood_group_id')
                                    <b>{{ $bloodGroups[$value] ?? $value }}</b>
                                @elseif($key === 'work_type_id')
                                    <b>{{ $professions[$value] ?? $value }}</b>
                                @elseif($key === 'travelled_country_id')
                                    @php
                                        $ids = is_array($value) ? $value : (is_string($value) ? json_decode($value, true) : []);
                                        $names = [];
                                        if (is_array($ids)) {
                                            foreach ($ids as $id) {
                                                $names[] = $travelledCountries[$id] ?? $id;
                                            }
                                        }
                                    @endphp
                                    <b>{{ implode(', ', $names) }}</b>
                                @elseif($key === 'passport_issue_place_id')
                                    <b>{{ $districts[$value] ?? $value }}</b>
                                @elseif($key === 'country_id')
                                    <b>{{ $countries[$value] ?? $value }}</b>
                                @elseif($key === 'division_id')
                                    <b>{{ $divisions[$value] ?? $value }}</b>
                                @elseif($key === 'district_id')
                                    <b>{{ $districts[$value] ?? $value }}</b>
                                @elseif($key === 'thana_id')
                                    <b>{{ $thanas[$value] ?? $value }}</b>
                                @elseif($key === 'post_office_id')
                                    <b>{{ $postOffices[$value] ?? $value }}</b>
                                @elseif($key === 'state_id')
                                    <b>{{ $states[$value] ?? $value }}</b>
                                @else
                                    <b>{{ $value }}</b>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endfor
            </tbody>
        </table>
    </div>
    
    <div class="form-group mt-4">
        <div class="form-check" style="padding-left: 0;">
            <input class="form-check-input" type="checkbox" id="confirmInfoCheckbox">
            <label class="form-check-label" for="confirmInfoCheckbox">
                I've confirmed that all the information I filled in is correct!
            </label>
        </div>
    </div>
</div>
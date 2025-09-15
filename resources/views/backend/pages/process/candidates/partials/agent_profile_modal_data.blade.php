<div class="row">
    <div class="col-md-3">
        <div class="image_area">
            <img
                src="{{ asset($agent->agent_photo ?? 'backend/images/avatar/no-photo.jpg') }}"
                alt="Agent Image"
                id="candidate_photo_preview"
                class="img-responsive img-thumbnail rounded-circle"
                style="width: 250px; height: 250px; object-fit: cover;"
            >
        </div>
    </div>

    <div class="col-md-9">
        <b><u>Agent Information:</u></b>
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td style="width: 180px;">Name</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $agent->first_name ?? '' }} {{ $agent->last_name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Phone number</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $agent->phone_number ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Email</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $agent->email ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Country</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;"><b>{{ $agent->country?->name ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Address</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">Current Address: <b>{{ $agent->current_address ?? '' }}</b>  Permanent Address: <b>{{ $agent->parmanent_address ?? '' }}</b></td>
                </tr>
                <tr>
                    <td style="width: 180px;">Passport scan copy</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($agent->passport_scan_copy ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 180px;">Balance Sheet</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($agent->opening_balance_sheet ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 180px;">Attachment</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 250px;">
                        <b>
                            <a href="{{ asset($agent->attachment ?? 'backend/images/avatar/no-photo.jpg') }}" target="_blank" title="Click to view files">
                                <i class="fa fa-eye"></i>
                            </a>
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

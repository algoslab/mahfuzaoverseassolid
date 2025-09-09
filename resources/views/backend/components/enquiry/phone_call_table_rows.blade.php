@foreach ($phoneCalls as $key => $call)
    <tr>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fa fa-bars"></i> Action
                </button>
                <div class="dropdown-menu">
                    <button type="button" class="dropdown-item addFollowupBtn" data-id="{{ $call->id }}">
                        <i class="fa fa-plus"></i> Add Follow Up
                    </button>
                    <button type="button" class="dropdown-item editPhoneCallBtn" data-id="{{ $call->id }}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <button type="button" class="dropdown-item text-danger deletePhoneCallBtn"
                        data-id="{{ $call->id }}">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </td>
        <td>{{ $key + 1 }}</td>
        <td>{{ $call->phone ?? 'N/A' }}</td>
        <td class="wrap-text">{{ $call->full_name ?? 'N/A' }}</td>
        <td>{{ $call->note ?? 'N/A' }}</td>
        <td>{{ $call->is_candidate ? 'Yes' : 'No' }}</td>
        <td>{{ $call->followup_time ? \Carbon\Carbon::parse($call->followup_time)->format('g:i A') : 'N/A' }}</td>
        <td>{{ $call->entry_type ?? 'N/A' }}</td>
        <td>{{ $call->followup_date ? \Carbon\Carbon::parse($call->followup_date)->format('d, F Y') : 'N/A' }}</td>
        <td>{{ $call->employee_id ? $call->employee->fast_name . ' ' . $call->employee->last_name : 'N/A' }}</td>
        <td class="wrap-text">{{ $call->process ?? 'N/A' }}</td>
    </tr>
@endforeach

<div class="modal fade" id="employeeFeedbackReportModal" tabindex="-1" role="dialog"
    aria-labelledby="employeeFeedbackReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeFeedbackReportModalLabel">Employee Phone Call Feedback Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="employee-feedback-list-section">
                    <div class="table-responsive">
                        <table id="employeeFeedbackReportTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th title="Nubmer of Phone Call Entry">NOPE</th>
                                    <th title="Number of Feedback entry">NOFE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $index => $employee)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $employee->employee_code }}</td>
                                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td>0</td>
                                        <td>
                                            <a href="#" class="show-followups badge-primary pl-2 pr-2 "
                                                data-employee-index="{{ $index }}"
                                                data-employee-name="{{ $employee->first_name }} {{ $employee->last_name }}">
                                                {{ count($employee->phone_call_followups) ?? 0 }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="employee-followup-accordion-section" style="display:none;">
                    <div class="d-flex align-items-center mb-3">
                        <button type="button" class="btn btn-secondary btn-sm mr-2" id="backToListBtn">&larr;
                            Back</button>
                        <h5 class="mb-0" id="followupAccordionHeader">Follow Up List</h5>
                    </div>
                    <div id="employeeFollowupAccordion">
                        @foreach ($employees as $index => $employee)
                            <div class="employee-followup-accordion" data-employee-index="{{ $index }}"
                                style="display:none;">
                                <div class="accordion" id="accordion-{{ $index }}">
                                    @forelse($employee->phone_call_followups as $fIndex => $followup)
                                        <div class="card">
                                            <div class="card-header p-0"
                                                id="heading-{{ $index }}-{{ $fIndex }}">
                                                <h2 class="mb-0 pb-2">
                                                    <button class="btn btn-link btn-block text-left" width="100%" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapse-{{ $index }}-{{ $fIndex }}"
                                                        aria-expanded="true"
                                                        aria-controls="collapse-{{ $index }}-{{ $fIndex }}">
                                                        {{ $followup->process }} ||
                                                        {{ $followup->phoneCall->full_name ?? 'N/A' }} ||
                                                        {{ $followup->phoneCall->phone ?? '' }} ||
                                                        {{ \Carbon\Carbon::parse($followup->followup_date)->format('d, F Y') }} - 
                                                        {{ \Carbon\Carbon::parse($followup->followup_time)->format('g:i A') }}
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapse-{{ $index }}-{{ $fIndex }}"
                                                class="collapse"
                                                aria-labelledby="heading-{{ $index }}-{{ $fIndex }}"
                                                data-parent="#accordion-{{ $index }}">
                                                <div class="card-body">
                                                    <div class="d-flex flex-wrap full-height">
                                                        <div class="col-12 col-md-6">
                                                            <p>Followup History</p>
                                                            <hr>
                                                            <strong>Note:</strong> {{ $followup->note ?? 'N/A' }}<br>
                                                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($followup->followup_date)->format('d, F Y') ?? 'N/A' }}<br>
                                                            <strong>Time:</strong> {{ \Carbon\Carbon::parse($followup->followup_time)->format('g:i A')  ?? 'N/A' }}<br>
                                                            <strong>Process:</strong> {{ $followup->process ?? 'N/A' }}
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <p>Phone Call Details</p>
                                                            <hr>
                                                            <strong>Name:</strong> {{ $followup->phoneCall->full_name ?? 'N/A' }}<br>
                                                            <strong>Phone:</strong> {{ $followup->phoneCall->phone ?? 'N/A' }}<br>
                                                            <strong>Email:</strong> {{ $followup->phoneCall->email ?? 'N/A' }}<br>
                                                            <strong>Candidate Type:</strong> {{ $followup->phoneCall->candidate_type_id ?? 'N/A' }}<br>
                                                            <strong>Followup Date:</strong> {{  \Carbon\Carbon::parse($followup->phoneCall->followup_date)->format('d, F Y')  ?? 'N/A' }}<br>
                                                            <strong>Note:</strong> {{ $followup->phoneCall->note ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info mb-0">No follow-ups found for this employee.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

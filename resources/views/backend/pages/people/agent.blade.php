@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Agents')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
    </style>
@endsection

@section('content')

@if (session('status'))
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (session('status') == 'success')
                    <i class="fas fa-check-circle text-success"></i>
                    <h5 class="mt-3 text-success">Success</h5>
                @else
                    <i class="fas fa-times-circle text-danger"></i>
                    <h5 class="mt-3 text-danger">Error</h5>
                @endif
                <p class="mt-2">{{ session('message') }}</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="box">
    <!-- Header Section -->
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <div>
            <h3 class="box-title">Agents Information</h3>
            <h6 class="box-subtitle">This is all agent List</h6>
        </div>
        <button type="button" class="btn btn-warning addAgentButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.people.agent_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Agent Photo</th>
                        <th style="">Agent Name</th>
                        <th style="">Agent Code</th>
                        <th style="">Registation Fee</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $key =>$data)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button inside Dropdown -->
                                    <a href="#" class="dropdown-item editAgentButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $data->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <!-- Delete Form inside Dropdown -->
                                    <button type="button"
                                            class="dropdown-item text-danger deleteagentBtn"
                                            data-id="{{ $data->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $data->agent_photo) }}" alt="Photo" width="50" height="50">
                        </td>
                        <td class="wrap-text">{{ $data->first_name  }} {{ $data->last_name  }} </td>
                        <td>{{ $data->agent_code}}</td>
                        <td class="wrap-text">
                            @if ($data->take_registration_fee == 1)
                                <span style="color: green;">
                                {{ $data->registration_fee_amount ?? '' }}
                                </span>
                            @else
                                <span style="color: red;">No</span>
                            @endif
                        </td>
                        
                        <td>
                            <span class="badge {{ $data->status === 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $data->status === 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

    @section('script')
        <script>
            $('#modal-center').on('shown.bs.modal', function () {
                $('.wrapper').removeAttr('aria-hidden');
            });
            $('#modal-center').on('hidden.bs.modal', function () {
                $('.wrapper').attr('aria-hidden', 'true');
            });

            function fetchagent() {
                $.ajax({
                    url: '{{ route("admin.agents.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh agent table.');
                    }
                });
            }
            fetchCountriess();
            fetchDivisions();
            fetchDistricts();
            fetchThanas();
            fetchEmployees();
            fetchBranch();

            $(document).ready(function () {
                $('#agentForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#agent_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#agent_id').val();

                    let url = isEdit
                        ? `{{ route('admin.agents.update', ['agent' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.agents.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Agent?" : "Add Agent?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, proceed"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    if (response.status === 'success') {
                                        $('#modal-center').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#agentForm')[0].reset();
                                        $('#agent_id').val('');
                                        fetchagent();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    let message = 'Failed to save agent.';

                                    if (xhr.responseJSON?.errors) {
                                        const errors = xhr.responseJSON.errors;
                                        message = Object.values(errors).flat().join('<br>');
                                    } else if (xhr.responseJSON?.message) {
                                        message = xhr.responseJSON.message;
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        html: message
                                    });
                                }
                            });
                        }
                    });
                });


                $(document).ready(function () {
                    $('#take_registration_fee').on('change', function () {
                        if ($(this).is(':checked')) {
                            $('.registation-fields').slideDown();
                            $('#registration_fee_amount').attr('required', true);
                        } else {
                            $('.registation-fields').slideUp();
                            $('#registration_fee_amount').removeAttr('required').val('');
                        }
                    });
                });

                $(document).on('click', '.addAgentButton', function () {
                    $('#agentForm')[0].reset();
                    $('#agent_id').val('');
                    $('#modalTitle').text('Add Agent Information')
                    $('#take_registration_fee').on('change', function () {
                        if ($(this).is(':checked')) {
                            $('.registation_fields').slideDown();
                            $('#registration_fee_amount').attr('required', true);
                        } else {
                            $('.registation_fields').slideUp();
                            $('#registration_fee_amount').removeAttr('required').val('');
                        }
                    });
                });

                $(document).on('click', '.editAgentButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.agents.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            console.log(res);
                            $('#agent_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#bonous_type').val(res.bonous_type);
                            $('#registration_fee_amount').val(res.registration_fee_amount);
                            $('#take_registration_fee').prop('checked', res.take_registration_fee == 1);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status == 1);
                            $('#modalTitle').text('Edit agent');
                            $('#modal-center').modal('show');
                            $('#countriesSelect').val(res.agent_id).trigger('change');

                                // Toggle bonus fields based on checkbox value
                            $('#take_registration_fee').on('change', function () {
                                if ($(this).is(':checked')) {
                                    $('.registation_fields').slideDown();
                                    $('#registration_fee_amount').attr('required', true);
                                } else {
                                    $('.registation_fields').slideUp();
                                    $('#registration_fee_amount').removeAttr('required').val('');
                                }
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load agent data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.deleteagentBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.agents.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete agent?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire('Deleted!', res.message, 'success');
                                        fetchagent();
                                    } else {
                                        Swal.fire('Error!', res.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection

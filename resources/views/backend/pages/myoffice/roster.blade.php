@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Roster Page')

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
            <h3 class="box-title">Roster</h3>
            <h6 class="box-subtitle">This is all Roster List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.myOffice.roster_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Roster Name</th>
                        <th style="">Roster Code</th>
                        <th style="">Meal Breck</th>
                        <th style="">Note</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rosters as $key =>$serivice)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button inside Dropdown -->
                                    <a href="#" class="dropdown-item editBlogButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $serivice->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <!-- Delete Form inside Dropdown -->
                                    <button type="button"
                                            class="dropdown-item text-danger deleteRosterBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $serivice->name  }}</td>
                        <td>{{ $serivice->code}}</td>
                        <td>
                            <span class="badge {{ $serivice->meal_break == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->meal_break == 1 ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>{{ $serivice->note ?? ''}}</td>
                        <td>
                            <span class="badge {{ $serivice->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status == 1 ? 'Active' : 'Inactive' }}
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
            function fetchRoster() {
                $.ajax({
                    url: '{{ route("admin.rosters.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Roster table.');
                    }
                });
            }

            $('#modal-center').on('shown.bs.modal', function () {
                $('.wrapper').removeAttr('aria-hidden');
            });

            // When the modal is hidden
            $('#modal-center').on('hidden.bs.modal', function () {
                $('.wrapper').attr('aria-hidden', 'true');
            });

            $(document).ready(function () {
                function calculateEndTime() {
                    const startTime = $('#start_time').val();
                    const dutyHours = parseFloat($('#duty_hours').val());

                    if (startTime && !isNaN(dutyHours)) {
                        const [hours, minutes] = startTime.split(':').map(Number);
                        const start = new Date();
                        start.setHours(hours);
                        start.setMinutes(minutes);
                        start.setSeconds(0);

                        const totalMinutes = dutyHours * 60;
                        start.setMinutes(start.getMinutes() + totalMinutes);

                        const endHours = String(start.getHours()).padStart(2, '0');
                        const endMinutes = String(start.getMinutes()).padStart(2, '0');
                        const endTime = `${endHours}:${endMinutes}`;

                        $('#end_time').val(endTime).prop('disabled', true);
                    }
                }
                $('#duty_hours, #start_time').on('input change', calculateEndTime);

                $('#rosterFrom').on('submit', function (e) {
                    e.preventDefault();

                    // 🔧 Force end time calculation before submission
                    calculateEndTime();

                    // ✅ Validate end_time is filled
                    const endTime = $('#end_time').val();
                    if (!endTime) {
                        Swal.fire('Validation Error', 'End Time must be calculated before submitting.', 'error');
                        return;
                    }
                    $('#end_time').prop('disabled', false);
                    let isEdit = $('#roster_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#roster_id').val();

                    let url = isEdit
                        ? `{{ route('admin.rosters.update', ['roster' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.rosters.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Roster?" : "Add Roster?",
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
                                        $('#rosterFrom')[0].reset();
                                        $('#roster_id').val('');
                                        fetchRoster();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    let message = 'Failed to save Department.';

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




                $(document).on('click', '.addBlogButton', function () {
                    $('#rosterFrom')[0].reset();
                    $('#roster_id').val('');
                    $('#modalTitle').text('Add Roster');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.rosters.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            console.log(res);
                            $('#roster_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#duty_hours').val(res.duty_hours);
                            $('#start_time').val(res.start_time.substring(0, 5));
                            $('#end_time').val(res.end_time.substring(0, 5));
                            $('#end_time').prop('readonly', true);
                            $('#meal_break').prop('checked', res.meal_break == 1);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status == 1);
                            $('#modalTitle').text('Edit Roster');
                            $('#modal-center').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Roster data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.deleteRosterBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.rosters.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Roster?',
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
                                        fetchRoster();
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

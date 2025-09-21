@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Dynamic Form')

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
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
             aria-hidden="true">
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
                <h3 class="box-title">Dynamic Forms</h3>
                <h6 class="box-subtitle">This is all Dynamic Forms List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('backend.components.process.dynamic_form_modal')
        @include('backend.components.process.setup_field_position_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable"
                       class="table table-bordered table-hover display nowrap">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Form Name</th>
                        <th style="">Fields</th>
                        <th style="">Entry Date</th>
                        <th style="">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $fKey => $item)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item setupButton" data-toggle="modal"
                                           data-target="#setup-field-position" data-id="{{ $item->id }}">
                                            <i class="fa fa-edit"></i> Setup Fields Position
                                        </a>
                                        <!-- Edit Button inside Dropdown -->
                                        <a href="#" class="dropdown-item editBlogButton" data-toggle="modal"
                                           data-target="#modal-center" data-id="{{ $item->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Form inside Dropdown -->
                                        <button type="button"
                                                class="dropdown-item text-danger deletecountryBtn"
                                                data-id="{{ $item->id }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $fKey + 1 }}</td>
                            <td class="wrap-text">{{ $item->form_name  }}</td>

                            <td style="width: 229.615px;">
                                <select onchange="add_new_field(this.value, {{ $item->id }})"
                                        class="form-control addNewField" style="width: 200px;margin:0px;">
                                    <option value="" disabled selected>Choose Field</option>
                                    <option value="id">id</option>
                                    <option value="candidate_type_id">candidate_type_id</option>
                                    <option value="candidate_type">candidate_type</option>
                                    <option value="is_tourist">is_tourist</option>
                                    <option value="agent_id">agent_id</option>
                                    <option value="agent_name">agent_name</option>
                                    <option value="referral_employee_id">referral_employee_id</option>
                                    <option value="referral_employee_name">referral_employee_name</option>
                                    <option value="interested_country_id">interested_country_id</option>
                                    <option value="interested_country_name">interested_country_name</option>
                                    <option value="interested_job_id">interested_job_id</option>
                                    <option value="interested_job_name">interested_job_name</option>
                                    <option value="process_country_id">process_country_id</option>
                                    <option value="process_country_name">process_country_name</option>
                                    <option value="process_job_id">process_job_id</option>
                                    <option value="process_job_name">process_job_name</option>
                                    <option value="nationality">nationality</option>
                                    <option value="first_name">first_name</option>
                                    <option value="last_name">last_name</option>
                                    <option value="full_name">full_name</option>
                                    <option value="gender">gender</option>
                                    <option value="date_of_birth">date_of_birth</option>
                                    <option value="email">email</option>
                                    <option value="phone_number">phone_number</option>
                                    <option value="password">password</option>
                                    <option value="contact_number">contact_number</option>
                                    <option value="nid_number">nid_number</option>
                                    <option value="father_name">father_name</option>
                                    <option value="mother_name">mother_name</option>
                                    <option value="spouse_name">spouse_name</option>
                                    <option value="nominee_name">nominee_name</option>
                                    <option value="religion">religion</option>
                                    <option value="marital_status">marital_status</option>
                                    <option value="blood_group">blood_group</option>
                                    <option value="nominee_relation">nominee_relation</option>
                                    <option value="note">note</option>
                                    <option value="experience_type">experience_type</option>
                                    <option value="old_company_name">old_company_name</option>
                                    <option value="old_job_id">old_job_id</option>
                                    <option value="old_job_name">old_job_name</option>
                                    <option value="departure_date">departure_date</option>
                                    <option value="arrival_date">arrival_date</option>
                                    <option value="departure_seal">departure_seal</option>
                                    <option value="arrival_seal">arrival_seal</option>
                                    <option value="old_company_address">old_company_address</option>
                                    <option value="travelled_country_ids">travelled_country_ids</option>
                                    <option value="passport_type">passport_type</option>
                                    <option value="passport_number">passport_number</option>
                                    <option value="old_passport_number">old_passport_number</option>
                                    <option value="passport_issue_date">passport_issue_date</option>
                                    <option value="passport_expired_date">passport_expired_date</option>
                                    <option value="passport_issue_place">passport_issue_place</option>
                                    <option value="passport_issue_place_name">passport_issue_place_name</option>
                                    <option value="validity_year">validity_year</option>
                                    <option value="passport_scan_copy">passport_scan_copy</option>
                                    <option value="passport_note">passport_note</option>
                                    <option value="country_id">country_id</option>
                                    <option value="country_name">country_name</option>
                                    <option value="division_id">division_id</option>
                                    <option value="division_name">division_name</option>
                                    <option value="district_id">district_id</option>
                                    <option value="district_name">district_name</option>
                                    <option value="thana_id">thana_id</option>
                                    <option value="thana_name">thana_name</option>
                                    <option value="postoffice_id">postoffice_id</option>
                                    <option value="postoffice_name">postoffice_name</option>
                                    <option value="postoffice_code">postoffice_code</option>
                                    <option value="state_id">state_id</option>
                                    <option value="state_name">state_name</option>
                                    <option value="current_address">current_address</option>
                                    <option value="permanent_address">permanent_address</option>
                                    <option value="candidate_photo">candidate_photo</option>
                                    <option value="polication_verification_file">polication_verification_file</option>
                                    <option value="other_certification">other_certification</option>
                                    <option value="optional_files">optional_files</option>
                                    <option value="comments">comments</option>
                                    <option value="commission_amount">commission_amount</option>
                                    <option value="is_child">is_child</option>
                                    <option value="status">status</option>
                                    <option value="visa_id">visa_id</option>
                                    <option value="sponsor_id">sponsor_id</option>
                                    <option value="sponsor_name">sponsor_name</option>
                                    <option value="is_start">is_start</option>
                                    <option value="is_completed">is_completed</option>
                                    <option value="running_step">running_step</option>
                                    <option value="total_step">total_step</option>
                                    <option value="is_duplicate">is_duplicate</option>
                                    <option value="terminated_note">terminated_note</option>
                                    <option value="terminated_attachment">terminated_attachment</option>
                                    <option value="uploader_info">uploader_info</option>
                                    <option value="data">data</option>
                                    <option value="date_filter">date_filter</option>
                                </select>
                                <ul id="form-fields-{{ $item->id }}">
                                    @foreach($item->updatedCandidateDynamicFormFields as $field)
                                        <li id="field-{{ $field->id }}">
                                            <a href="javascript:void(0);" class="text-primary copyFieldBtn"
                                               data-field-id="{{ $field->id }}" title="Copy">
                                                <i class="mdi mdi-content-copy"></i>
                                            </a>&nbsp;|&nbsp;

                                            <a href="javascript:void(0);" class="text-danger removeFieldBtn"
                                               data-field-id="{{ $field->id }}" title="Remove">
                                                <i class="fa fa-trash-o"></i>
                                            </a>&nbsp;|&nbsp;

                                            {{ $field->field_name }}
                                        </li>
                                    @endforeach
                                </ul>


                            </td>

                            <td class="wrap-text">{{ $item->created_at->format('F d, Y') }}</td>
                            <td>
        <span class="badge {{ $item->status == 'Enabled' ? 'badge-success' : 'badge-danger' }}">
            {{ $item->status == 'Enabled' ? 'Enabled' : 'Disabled' }}
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
            function fetchDynamicForms() {
                $.ajax({
                    url: '{{ route("admin.candidate-dynamic-forms.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh dynamic form table.');
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

            function add_new_field(fieldName, formId) {
                if (!fieldName) return;

                $.ajax({
                    url: '/admin/fields/add',
                    type: 'POST',
                    data: {
                        candidate_dynamic_form_id: formId,
                        field_name: fieldName,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            let newField = response.new_field;

                            let newLi = `
<li id="field-${newField.id}">
    <a href="javascript:void(0);" class="text-primary copyFieldBtn"
       data-field-id="${newField.id}" title="Copy">
       <i class="mdi mdi-content-copy"></i>
    </a>&nbsp;|&nbsp;

    <a href="javascript:void(0);" class="text-danger removeFieldBtn"
       data-field-id="${newField.id}" title="Remove">
       <i class="fa fa-trash-o"></i>
    </a>&nbsp;|&nbsp;

    ${newField.field_name}
</li>`;
                            $(`#form-fields-${newField.candidate_dynamic_form_id}`).append(newLi);
                            Swal.fire('Success!', response.message, 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to add field.', 'error');
                    }
                });
            }

            $(document).on('click', '.copyFieldBtn', function () {
                let fieldId = $(this).data('field-id');

                $.ajax({
                    url: '/admin/fields/copy',
                    type: 'POST',
                    data: {
                        field_id: fieldId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            let newField = response.new_field;
                            let newLi = `
<li id="field-${newField.id}">
    <a href="javascript:void(0);" class="text-primary copyFieldBtn"
       data-field-id="${newField.id}" title="Copy">
       <i class="mdi mdi-content-copy"></i>
    </a>&nbsp;|&nbsp;

    <a href="javascript:void(0);" class="text-danger removeFieldBtn"
       data-field-id="${newField.id}" title="Remove">
       <i class="fa fa-trash-o"></i>
    </a>&nbsp;|&nbsp;

    ${newField.field_name}
</li>`;
                            $(`#field-${fieldId}`).closest('ul').append(newLi);
                            Swal.fire('Success!', response.message, 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to copy field.', 'error');
                    }
                });
            });

            $(document).on('click', '.removeFieldBtn', function () {
                let fieldId = $(this).data('field-id');

                Swal.fire({
                    title: 'Delete Field?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/fields/' + fieldId,   // ✅ leading slash
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                console.log("Delete response:", response); // 🔍 debug

                                if (response.status === 'success') { // ✅ check correct key
                                    $('#field-' + fieldId).remove();
                                    Swal.fire('Deleted!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error!', 'Failed to delete field.', 'error');
                            }
                        });
                    }
                });
            });


            $(document).ready(function () {

                $('#dynamicForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#dynamic_form_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#dynamic_form_id').val();
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');
                    const baseUpdateUrl = "{{ url('admin/candidate-dynamic-forms') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('admin.candidate-dynamic-forms.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update dynamic form?" : "Add dynamic form?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, proceed"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: method,
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    if (response.status === 'success') {
                                        $('#modal-center').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#dynamicForm')[0].reset();
                                        $('#dynamic_form_id').val('');
                                        fetchDynamicForms();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save dynamic form.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#dynamicForm')[0].reset();
                    $('#dynamic_form_id').val('');
                    $('#modalTitle').text('Add dynamic form');
                    $('#modal-center').modal('show');
                });

                const storageBaseUrl = "{{ asset('') }}";

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.candidate-dynamic-forms.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#dynamic_form_id').val(id);
                            $('#form_name').val(res.form_name);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status === 'Enabled');

                            if (res.background_image) {
                                $('#preview').attr('src', storageBaseUrl + res.background_image);
                                $('#preview').show();
                                $('#remove-file-section').removeClass('d-none');
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#preview').attr('src', '');
                                $('#preview').hide();
                                $('#remove-file-section').addClass('d-none');
                                $('#remove_file').prop('checked', false);
                            }

                            $('#modalTitle').text('Edit Dynamic form');
                            $('#modal-center').modal('show');
                            let selectedFields = res.candidate_dynamic_form_fields.map(f => f.field_name);

                            // Preselect in Select2
                            $('#field_name').val(selectedFields).trigger('change');

                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load dynamic form data.', 'error');
                        }
                    });
                });
                $(document).on('click', '.setupButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.candidate-dynamic-forms.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#form_name_show').text(res.form_name);
                            $('#setup-field-position').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load dynamic form data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deletecountryBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.candidate-dynamic-forms.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Dynamic Form?',
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
                                        fetchDynamicForms();
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

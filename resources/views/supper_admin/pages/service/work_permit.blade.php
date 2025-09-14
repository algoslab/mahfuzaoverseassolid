@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Work Permit')

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
            <h3 class="box-title">Work Permit</h3>
            <h6 class="box-subtitle">This is all work permit List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('supper_admin.components.services.workpermit_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Expire Date</th>
                        <th style="">Name</th>
                        <th style="">Salary</th>
                        <th style="">Continent</th>
                        <th style="">Country</th>
                        <th style="">Code</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workpermits as $key =>$serivice)
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
                                            class="dropdown-item text-danger deleteWorkPermitBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $serivice->expire_date}}</td>
                        <td>{{ $serivice->name}}</td>
                        <td>{{ $serivice->salary}}</td>
                        <td class="wrap-text">{{ $serivice->continent->name  }}</td>
                        <td class="wrap-text">{{ $serivice->country->name  }}</td>
                        <td class="wrap-text">{{ $serivice->code  }}</td>
                        <td>
                            <span class="badge {{ $serivice->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status == 'Active' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="wrap-text">{{ $serivice->created_at->format('F d, Y') }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

    @section('script')
        <script>
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('preview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function fetchWorkPermits() {
                $.ajax({
                    url: '{{ route("admin.workpermits.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh workpermit table.');
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

                fetchContinents();
                function fetchContinents() {
                    $.ajax({
                        url: "{{ route('supper_admin.continent.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#continentSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Continent</option>');
                            data.forEach(function(continent) {
                                select.append('<option value="' + continent.id + '">' + continent.name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch continents:", xhr);
                        }
                    });
                }

                // Fetch Countries based on Continent
                function fetchCountries(continentId, selectedCountryId) {
                    $.ajax({
                        url: "{{ route('admin.country.active') }}",
                        method: "GET",
                        data: { continent_id: continentId }, // Pass continent_id to filter countries
                        success: function (data) {
                            let select = $('#countriesSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a country</option>');
                            data.forEach(function(country) {
                                let selected = country.id == selectedCountryId ? 'selected' : '';
                                select.append('<option value="' + country.id + '" ' + selected + '>' + country.name + '</option>');
                            });

                            // Ensure the country dropdown value is updated after population
                            select.val(selectedCountryId).trigger('change');  // Set selected country
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch countries:", xhr);
                        }
                    });
                }

                // Trigger the fetchCountries function when a continent is selected
                $('#continentSelect').on('change', function() {
                    const continentId = $(this).val();
                    if (continentId) {
                        fetchCountries(continentId);  // Fetch countries based on the selected continent
                    } else {
                        $('#countriesSelect').empty().append('<option value="" disabled selected>Select a Country</option>');
                    }
                });


                $('#workpermitForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#work_permit_id').val() !== ''; 
                    let formData = new FormData(this); 
                    let id = $('#work_permit_id').val(); 
                    let url = isEdit 
                        ? `{{ route('admin.workpermits.update', ['workpermit' => '__id__']) }}`.replace('__id__', id) 
                        : `{{ route('admin.workpermits.store') }}`;

                    let method = isEdit ? 'POST' : 'POST'; 
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update country?" : "Add Work Permit?",
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
                                        $('#workpermitForm')[0].reset();
                                        $('#work_permit_id').val('');
                                        fetchWorkPermits();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save country.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#workpermitForm')[0].reset();
                    $('#work_permit_id').val('');
                    $('#continentSelect').val('').trigger('change');  
                    $('#countriesSelect').empty().append('<option value="" disabled selected>Select a country</option>');  
                    $('#preview').attr('src', '').hide();
                    $('#modalTitle').text('Add Work Permit');
                    $('#modal-center').modal('show');
                    
                });

                const storageBaseUrl = "{{ asset('storage') }}/";
                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.workpermits.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#work_permit_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#salary').val(res.salary);
                            $('#expire_date').val(res.expire_date);
                            if (res.image) {
                                $('#preview').attr('src', storageBaseUrl + res.image);
                                $('#preview').show(); 
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#preview').attr('src', '');
                                $('#preview').hide(); 
                            }
                            $('#status').prop('checked', res.status === 'Active');
                            $('#modalTitle').text('Edit Work Permit');
                            $('#modal-center').modal('show');
                            $('#continentSelect').val(res.continent_id).trigger('change');
                            $('#countriesSelect').val(res.country_id).trigger('change');
                            fetchCountries(res.continent_id, res.country_id);
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load country data.', 'error');
                        }
                    });
                });




                $(document).on('click', '.deleteWorkPermitBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.workpermits.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete country?',
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
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire('Deleted!', response.message, 'success');
                                        fetchWorkPermits();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the work permit.', 'error');
                                }
                            });
                        }
                    });
                });
            });



        </script>

    @endsection
@endsection

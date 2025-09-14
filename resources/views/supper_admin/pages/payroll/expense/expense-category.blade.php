@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Expense Category')

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
                <h3 class="box-title">Expense Categories</h3>
                <h6 class="box-subtitle">This is all Expense Categories List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.payroll.expense.expense_category_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB.Id</th>
                        <th style="">Account Type</th>
                        <th style="">Expense Category Name</th>
                        <th style="">Expense Category Code</th>
                        <th style="">Balance</th>
                        <th style="">Opening Balance</th>
                        <th style="">Entry Date</th>
                        <th style="">Status</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenseCategories as $key =>$category)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- Edit Button inside Dropdown -->
                                        <a href="#" class="dropdown-item editBlogButton" data-toggle="modal"
                                           data-target="#modal-center" data-id="{{ $category->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Form inside Dropdown -->
                                        <button type="button"
                                                class="dropdown-item text-danger deleteContinentBtn"
                                                data-id="{{ $category->id }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category->account_type}}</td>

                            <td class="wrap-text">{{ $category->expense_category_name  }}</td>
                            <td class="wrap-text">{{ $category->expense_category_code  }}</td>
                            <td>{{ $category->opening_balance}}</td>
                            <td>{{ $category->opening_balance}}</td>
                            <td class="wrap-text">{{ $category->created_at->format('F d, Y') }}</td>
                            <td>
                            <span class="badge {{ $category->status == 'Enabled' ? 'badge-success' : 'badge-danger' }}">
                                {{ $category->status == 'Enabled' ? 'Enabled' : 'Disabled' }}
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
            function fetchExpenseCategories() {
                $.ajax({
                    url: '{{ route("admin.expense-categories.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh continent table.');
                    }
                });
            }

            $('#modal-center').on('shown.bs.modal', function () {
                // Remove aria-hidden from wrapper
                $('.wrapper').removeAttr('aria-hidden');
            });

            // When the modal is hidden
            $('#modal-center').on('hidden.bs.modal', function () {
                // Optionally, add aria-hidden back to wrapper
                $('.wrapper').attr('aria-hidden', 'true');
            });

            $(document).ready(function () {

                $('#expenseCategoryForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#expense_category_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#expense_category_id').val();
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');

                    const baseUpdateUrl = "{{ url('admin/expense-categories') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('admin.expense-categories.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Expense Category?" : "Add Expense Category?",
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
                                        $('#expenseCategoryForm')[0].reset();
                                        $('#expense_category_id').val('');
                                        fetchExpenseCategories();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save expense category.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#expenseCategoryForm')[0].reset();
                    $('#expense_category_id').val('');
                    $('#modalTitle').text('Add Expense Category');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.expense-categories.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#expense_category_id').val(id);
                            $('#account_type').val(res.account_type);
                            $('#expense_category_name').val(res.expense_category_name);
                            $('#expense_category_code').val(res.expense_category_code);
                            $('#opening_balance').val(res.opening_balance);
                            $('#note').val(res.note);

                            // Show existing file
                            if (res.opening_balance_sheet) {
                                const filePath = res.opening_balance_sheet; // example: expense_categories/filename.pdf
                                const ext = filePath.split('.').pop().toLowerCase();

                                // Prepend Laravel's public storage path
                                const fileUrl = `/${filePath}`;

                                let previewHtml = '';

                                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                    previewHtml = `<img src="${fileUrl}" alt="Uploaded File" class="img-thumbnail" style="max-height: 200px;">`;
                                } else {
                                    previewHtml = `<a href="${fileUrl}" target="_blank" class="btn btn-outline-primary btn-sm">View File</a>`;
                                }

                                $('#existing-file-preview').html(previewHtml);
                                $('#remove-file-section').removeClass('d-none');
                            } else {
                                $('#existing-file-preview').empty();
                                $('#remove-file-section').addClass('d-none');
                                $('#remove_file').prop('checked', false);
                            }
                            $('#status').prop('checked', res.status === 'Enabled');
                            $('#modalTitle').text('Edit Continent');
                            $('#modal-center').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load expense category data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteContinentBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.expense-categories.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Expense Category?',
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
                                        fetchExpenseCategories();
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

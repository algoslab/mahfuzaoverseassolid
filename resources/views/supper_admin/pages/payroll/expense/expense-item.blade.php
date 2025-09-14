@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Expense Item')

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
                <h3 class="box-title">Expense Items</h3>
                <h6 class="box-subtitle">This is all Expense Items List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.payroll.expense.expense_item_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Expense Category Name</th>
                        <th style="">Expense Item Name</th>
                        <th style="">Entry Date</th>
                        <th style="">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenseItems as $key =>$item)
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

                            <td>{{ $key + 1 }}</td>
                            <td class="wrap-text">{{$item->expenseCategory ? $item->expenseCategory->expense_category_name : '' }}</td>
                            <td class="wrap-text">{{ $item->expense_item_name  }}</td>
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
            function fetchExpenseItems() {
                $.ajax({
                    url: '{{ route("admin.expense-items.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh expense item table.');
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
                fetchExpenseCategories();

                function fetchExpenseCategories() {
                    $.ajax({
                        url: "{{ route('admin.expense-category.enabled') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#categorySelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Category</option>');
                            data.forEach(function (category) {
                                select.append(
                                    '<option value="' + category.id + '">' +
                                    category.expense_category_name + ' - ' + category.expense_category_code +
                                    '</option>'
                                );
                            });

                        },
                        error: function (xhr) {
                            console.error("Failed to fetch expense categories:", xhr);
                        }
                    });
                }

                $('#expenseItemForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#expense_item_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#expense_item_id').val();
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');
                    const baseUpdateUrl = "{{ url('admin/expense-items') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('admin.expense-items.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update expense item?" : "Add expense item?",
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
                                        $('#expenseItemForm')[0].reset();
                                        $('#expense_item_id').val('');
                                        fetchExpenseItems();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save expense item.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#expenseItemForm')[0].reset();
                    $('#expense_item_id').val('');
                    $('#modalTitle').text('Add expense item');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.expense-items.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#expense_item_id').val(id);
                            $('#expense_item_name').val(res.expense_item_name);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status === 'Enabled');
                            $('#modalTitle').text('Edit expense item');
                            $('#modal-center').modal('show');
                            $('#categorySelect').val(res.expense_category_id).trigger('change');

                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load expense item data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deletecountryBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.expense-items.destroy", ":id") }}'.replace(':id', id);

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
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire('Deleted!', res.message, 'success');
                                        fetchExpenseItems();
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

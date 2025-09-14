@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Company')

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
            <h3 class="box-title">Hazz & Umrah</h3>
            <h6 class="box-subtitle">This is all Hazz & Umrah List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('supper_admin.components.services.hazzumrah_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB.Id</th>
                        <th style="">Service</th>
                        <th style="">Packages</th>
                        <th style="">Transit</th>
                        <th style="">Hotel Category</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($hazzUmrah as $key =>$serivice)
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
                                    <form action="{{ route('admin.hazz-umrah.destroy', $serivice->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $serivice->services}}</td>

                        <td class="wrap-text">{{ $serivice->packages  }}</td>
                        <td class="wrap-text">{{ $serivice->transit }}</td>
                        <td class="wrap-text">{{ $serivice->hotel_category }}</td>
                        <td>
                            <span class="badge {{ $serivice->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status == 1 ? 'Active' : 'Inactive' }}
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
    $(document).ready(function() {
        // Edit Country Button
        $('.editblogCategoryButton').on('click', function () {
            const hazzUmrahId = $(this).data('id');
            const editUrl = '{{ route("admin.hazz-umrah.edit", ":id") }}'.replace(':id', hazzUmrahId);
            $.ajax({
                url: editUrl,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#modalTitle').text('Edit Hazz or Umrah');
                    $('#hazzUmrahForm').attr('action', '/blog/category/' + hazzUmrahId);
                    $('#name').val(response.name);
                    $('#note').val(response.note);
                    
                    if (response.status == 1) {
                        $('#status').prop('checked', true); 
                    } else {
                        $('#status').prop('checked', false); 
                    }
                    $('input[name="_method"]').remove();
                    $('#hazzUmrahForm').append('<input type="hidden" name="_method" value="PUT">');

                    // Show the modal
                    $('#modal-center').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching country details:', error);
                    alert('Failed to load country details. Please try again.');
                }
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('statusModal');
        if (modal) {
            $(modal).modal('show');
        }
    });

</script>
@endsection

@endsection

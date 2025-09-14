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
            <h3 class="box-title">Air Ticket</h3>
            <h6 class="box-subtitle">This is all Air Ticket List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('supper_admin.components.services.air_ticket_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead class="thead-light">
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th>File Name</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($airticketfile as $service)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item editBlogButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $service->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.air-ticket.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->file_name }}</td>
                        <td>{{ $service->upload_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>

@section('script')
@endsection

@endsection

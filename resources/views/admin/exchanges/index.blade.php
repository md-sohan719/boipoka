@extends('layouts.admin')

@section('title', 'Manage Exchanges')
@section('page-title', 'Manage Exchanges')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Exchanges</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Exchanges ({{ $exchanges->total() }})</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book</th>
                            <th>Requester</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exchanges as $exchange)
                            <tr>
                                <td>{{ $exchange->id }}</td>
                                <td>{{ $exchange->book->title }}</td>
                                <td>{{ $exchange->requester->name }}</td>
                                <td>{{ $exchange->owner->name }}</td>
                                <td>
                                    @php
                                        $statusClass = match($exchange->status) {
                                            'pending' => 'warning',
                                            'accepted' => 'success',
                                            'rejected' => 'danger',
                                            'completed' => 'info',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                </td>
                                <td>{{ $exchange->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('exchanges.show', $exchange) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No exchanges found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $exchanges->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

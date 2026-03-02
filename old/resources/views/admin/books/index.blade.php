@extends('layouts.admin')

@section('title', 'Manage Books')
@section('page-title', 'Manage Books')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Books</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Books ({{ $books->total() }})</h3>
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
                                <th>Title</th>
                                <th>Author</th>
                                <th>Owner</th>
                                <th>Condition</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td>{{ $book->id }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->user->name }}</td>
                                    <td>
                                        @php
                                            $conditionClass = match ($book->condition) {
                                                'new' => 'success',
                                                'like-new' => 'info',
                                                'good' => 'primary',
                                                'fair' => 'warning',
                                                'poor' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span
                                            class="badge badge-{{ $conditionClass }}">{{ ucfirst($book->condition) }}</span>
                                    </td>
                                    <td>${{ number_format($book->price, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = match ($book->status) {
                                                'available' => 'success',
                                                'sold' => 'danger',
                                                'reserved' => 'warning',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $statusClass }}">{{ ucfirst($book->status) }}</span>
                                    </td>
                                    <td>{{ $book->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.books.delete', $book) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this book?')"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No books found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $books->links('pagination::bootstrap-4') }}
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

@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Category Information</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">ID:</dt>
                                <dd class="col-sm-8">{{ $category->id }}</dd>

                                <dt class="col-sm-4">Name:</dt>
                                <dd class="col-sm-8">{{ $category->name }}</dd>

                                <dt class="col-sm-4">Slug:</dt>
                                <dd class="col-sm-8"><code>{{ $category->slug }}</code></dd>

                                <dt class="col-sm-4">Icon:</dt>
                                <dd class="col-sm-8">
                                    @if ($category->icon)
                                        <span style="font-size: 2rem;">{{ $category->icon }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Color:</dt>
                                <dd class="col-sm-8">
                                    @if ($category->color)
                                        <span class="badge"
                                            style="background-color: {{ $category->color }}; color: white; padding: 10px 20px;">
                                            {{ $category->color }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Description:</dt>
                                <dd class="col-sm-8">{{ $category->description ?? '-' }}</dd>

                                <dt class="col-sm-4">Status:</dt>
                                <dd class="col-sm-8">
                                    @if ($category->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-4">Books Count:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge badge-info">{{ $category->books->count() }}</span>
                                </dd>

                                <dt class="col-sm-4">Created:</dt>
                                <dd class="col-sm-8">{{ $category->created_at->format('M d, Y h:i A') }}</dd>

                                <dt class="col-sm-4">Updated:</dt>
                                <dd class="col-sm-8">{{ $category->updated_at->format('M d, Y h:i A') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Books</h3>
                        </div>
                        <div class="card-body p-0">
                            @if ($category->books->count() > 0)
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category->books as $book)
                                            <tr>
                                                <td>{{ Str::limit($book->title, 30) }}</td>
                                                <td>{{ $book->author }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($book->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="p-3 text-center text-muted">
                                    No books in this category yet
                                </div>
                            @endif
                        </div>
                        @if ($category->books->count() > 0)
                            <div class="card-footer text-center">
                                <a href="{{ route('admin.books.index', ['category' => $category->id]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View All Books
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <span class="material-icons logo-icon">dashboard</span>
                <span class="logo-text">{{ config('app.name') }}</span>
            </div>
            <button class="sidebar-toggle">
                <span class="material-icons">menu</span>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <span class="material-icons">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="nav-item">
                <span class="material-icons">people</span>
                <span>Users</span>
            </a>

            <a href="{{ route('admin.books') }}" class="nav-item active">
                <span class="material-icons">book</span>
                <span>Books</span>
            </a>

            <a href="{{ route('admin.exchanges') }}" class="nav-item">
                <span class="material-icons">swap_horiz</span>
                <span>Exchanges</span>
            </a>

            <a href="{{ route('home') }}" class="nav-item">
                <span class="material-icons">home</span>
                <span>Back to Site</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="footer-item">
                    <span class="material-icons">logout</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <div class="breadcrumb">
                <span class="material-icons bc-icon">book</span>
                <span class="bc-current">Manage Books</span>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Books ({{ $books->total() }})</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
                                    <td><span class="badge badge-{{ $book->condition }}">{{ $book->condition }}</span>
                                    </td>
                                    <td>${{ number_format($book->price, 2) }}</td>
                                    <td><span class="badge badge-{{ $book->status }}">{{ $book->status }}</span></td>
                                    <td>{{ $book->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.books.delete', $book) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this book?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-sm btn-danger">
                                                <span class="material-icons">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" style="text-align: center;">No books found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('admin/js/main.js') }}"></script>
</body>

</html>

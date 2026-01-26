<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exchanges | {{ config('app.name') }}</title>
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

            <a href="{{ route('admin.books') }}" class="nav-item">
                <span class="material-icons">book</span>
                <span>Books</span>
            </a>

            <a href="{{ route('admin.exchanges') }}" class="nav-item active">
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
                <span class="material-icons bc-icon">swap_horiz</span>
                <span class="bc-current">Manage Exchanges</span>
            </div>
        </header>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Exchanges ({{ $exchanges->total() }})</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
                                        <span class="badge badge-{{ $exchange->status }}">
                                            {{ ucfirst($exchange->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $exchange->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('exchanges.show', $exchange) }}" class="btn-icon-sm">
                                            <span class="material-icons">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center;">No exchanges found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    {{ $exchanges->links() }}
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('admin/js/main.js') }}"></script>
</body>

</html>

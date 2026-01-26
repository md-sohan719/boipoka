<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
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

        <div class="search-box">
            <span class="material-icons">search</span>
            <input type="text" placeholder="Search..." />
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <span class="material-icons">dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}" class="nav-item">
                <span class="material-icons">people</span>
                <span>Users</span>
                <span class="badge">{{ $stats['total_users'] }}</span>
            </a>

            <a href="{{ route('admin.books') }}" class="nav-item">
                <span class="material-icons">book</span>
                <span>Books</span>
                <span class="badge">{{ $stats['total_books'] }}</span>
            </a>

            <a href="{{ route('admin.exchanges') }}" class="nav-item">
                <span class="material-icons">swap_horiz</span>
                <span>Exchanges</span>
                <span class="badge">{{ $stats['pending_exchanges'] }}</span>
            </a>

            <a href="{{ route('home') }}" class="nav-item">
                <span class="material-icons">home</span>
                <span>Back to Site</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <div class="user-info">
                    <p class="user-name">{{ auth()->user()->name }}</p>
                    <p class="user-role">Admin</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="footer-item">
                    <span class="material-icons">logout</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="breadcrumb">
                <span class="material-icons bc-icon">dashboard</span>
                <span class="bc-current">Dashboard</span>
            </div>
            <div class="topbar-actions">
                <button class="btn-icon">
                    <span class="material-icons">calendar_today</span>
                    <span>{{ now()->format('M d, Y') }}</span>
                </button>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="stats-grid fade-in-up">
            <div class="stat-card-lg">
                <div class="stat-card-header">
                    <span class="stat-label">Total Users</span>
                    <span class="material-icons stat-icon-sm">people</span>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value-lg">{{ $stats['total_users'] }}</h2>
                </div>
                <div class="stat-card-footer">
                    <span class="material-icons">info_outline</span>
                    <span>Registered users</span>
                </div>
            </div>

            <div class="stat-card-lg">
                <div class="stat-card-header">
                    <span class="stat-label">Total Books</span>
                    <span class="material-icons stat-icon-sm">book</span>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value-lg">{{ $stats['total_books'] }}</h2>
                </div>
                <div class="stat-card-footer">
                    <span class="material-icons">info_outline</span>
                    <span>Listed books</span>
                </div>
            </div>

            <div class="stat-card-lg">
                <div class="stat-card-header">
                    <span class="stat-label">Total Exchanges</span>
                    <span class="material-icons stat-icon-sm">swap_horiz</span>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value-lg">{{ $stats['total_exchanges'] }}</h2>
                </div>
                <div class="stat-card-footer">
                    <span class="material-icons">info_outline</span>
                    <span>All exchanges</span>
                </div>
            </div>

            <div class="stat-card-lg">
                <div class="stat-card-header">
                    <span class="stat-label">Pending Exchanges</span>
                    <span class="material-icons stat-icon-sm">pending</span>
                </div>
                <div class="stat-card-body">
                    <h2 class="stat-value-lg">{{ $stats['pending_exchanges'] }}</h2>
                </div>
                <div class="stat-card-footer">
                    <span class="material-icons">info_outline</span>
                    <span>Awaiting approval</span>
                </div>
            </div>
        </div>

        <!-- User Role Distribution -->
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">User Role Distribution</h3>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="material-icons stat-icon-lg">person</span>
                        <div>
                            <h4 class="stat-value-sm">{{ $stats['buyers'] }}</h4>
                            <p class="stat-label-sm">Buyers</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="material-icons stat-icon-lg">store</span>
                        <div>
                            <h4 class="stat-value-sm">{{ $stats['sellers'] }}</h4>
                            <p class="stat-label-sm">Sellers</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <span class="material-icons stat-icon-lg">admin_panel_settings</span>
                        <div>
                            <h4 class="stat-value-sm">{{ $stats['admins'] }}</h4>
                            <p class="stat-label-sm">Admins</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
    </main>

    <script src="{{ asset('admin/js/main.js') }}"></script>
</body>

</html>

@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $stats['total_users'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Books</span>
                <span class="info-box-number">{{ $stats['total_books'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="clearfix hidden-md-up"></div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-exchange-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Exchanges</span>
                <span class="info-box-number">{{ $stats['total_exchanges'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pending Exchanges</span>
                <span class="info-box-number">{{ $stats['pending_exchanges'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- User Role Distribution -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    User Role Distribution
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Buyers</span>
                                <span class="info-box-number">{{ $stats['buyers'] }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_users'] > 0 ? ($stats['buyers'] / $stats['total_users']) * 100 : 0 }}%"></div>
                                </div>
                                <span class="progress-description">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['buyers'] / $stats['total_users']) * 100, 1) : 0 }}% of total users
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-gradient-success">
                            <span class="info-box-icon"><i class="fas fa-store"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sellers</span>
                                <span class="info-box-number">{{ $stats['sellers'] }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_users'] > 0 ? ($stats['sellers'] / $stats['total_users']) * 100 : 0 }}%"></div>
                                </div>
                                <span class="progress-description">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['sellers'] / $stats['total_users']) * 100, 1) : 0 }}% of total users
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="info-box bg-gradient-danger">
                            <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Admins</span>
                                <span class="info-box-number">{{ $stats['admins'] }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['total_users'] > 0 ? ($stats['admins'] / $stats['total_users']) * 100 : 0 }}%"></div>
                                </div>
                                <span class="progress-description">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['admins'] / $stats['total_users']) * 100, 1) : 0 }}% of total users
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-app bg-info">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.books') }}" class="btn btn-app bg-success">
                            <i class="fas fa-book"></i> Manage Books
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.exchanges') }}" class="btn btn-app bg-warning">
                            <span class="badge bg-danger">{{ $stats['pending_exchanges'] }}</span>
                            <i class="fas fa-exchange-alt"></i> Exchanges
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('home') }}" class="btn btn-app bg-primary">
                            <i class="fas fa-home"></i> View Site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    System Overview
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Count</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Users</td>
                                <td>{{ $stats['total_users'] }}</td>
                                <td><span class="badge badge-info">Active</span></td>
                            </tr>
                            <tr>
                                <td>Total Books</td>
                                <td>{{ $stats['total_books'] }}</td>
                                <td><span class="badge badge-success">Available</span></td>
                            </tr>
                            <tr>
                                <td>Total Exchanges</td>
                                <td>{{ $stats['total_exchanges'] }}</td>
                                <td><span class="badge badge-primary">Processing</span></td>
                            </tr>
                            <tr>
                                <td>Pending Exchanges</td>
                                <td>{{ $stats['pending_exchanges'] }}</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Additional styles if needed -->
@endpush

@push('scripts')
<!-- Additional scripts if needed -->
@endpush

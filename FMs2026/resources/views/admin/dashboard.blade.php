@extends('layouts.app')

@section('title', __('app.admin.title'))

@section('content')
    <div class="admin-container">
        <div class="admin-header">
            <h1>{{ __('app.admin.title') }}</h1>
            <p>{{ session('username') }}!</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">{{ __('app.admin.total_users') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $adminCount }}</div>
                <div class="stat-label">{{ __('app.admin.administrators') }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $playerCount }}</div>
                <div class="stat-label">{{ __('app.admin.players') }}</div>
            </div>
        </div>

        <div class="admin-menu">
            <a href="{{ route('admin.users') }}" class="admin-menu-item">
                <span class="icon">👥</span>
                <span>{{ __('app.admin.manage_users') }}</span>
            </a>
            <a href="{{ route('admin.statistics') }}" class="admin-menu-item">
                <span class="icon">📊</span>
                <span>{{ __('app.admin.statistics') }}</span>
            </a>
            <a href="{{ route('dashboard') }}" class="admin-menu-item">
                <span class="icon">🏠</span>
                <span>{{ __('app.admin.return_to_game') }}</span>
            </a>
        </div>

        <div class="recent-users">
            <h2>{{ __('app.admin.recent_users') }}</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('app.admin.username') }}</th>
                            <th>{{ __('app.admin.email') }}</th>
                            <th>{{ __('app.admin.role') }}</th>
                            <th>{{ __('app.admin.registration_date') }}</th>
                            <th>{{ __('app.admin.last_login') }}</th>
                            <th>{{ __('app.admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr>
                                <td><strong>{{ $user->Username }}</strong></td>
                                <td>{{ $user->Email }}</td>
                                <td>
                                    <span class="badge badge-{{ $user->role }}">
                                        {{ $user->role === 'admin' ? __('app.admin.admin') : __('app.admin.player') }}
                                    </span>
                                </td>
                                <td>{{ $user->RegisterDate->format('d.m.Y') }}</td>
                                <td>{{ $user->LastLogin->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->UserID) }}" class="btn-small">{{ __('app.admin.view') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: #333;
        }

        .admin-header p {
            color: #666;
            margin: 10px 0 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .admin-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
        }

        .admin-menu-item {
            background: white;
            border: 2px solid #e0e0e0;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .admin-menu-item:hover {
            border-color: #667eea;
            background: #f8f9ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }

        .admin-menu-item .icon {
            font-size: 1.5rem;
        }

        .recent-users {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .recent-users h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #666;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-admin {
            background-color: #ffd700;
            color: #333;
        }

        .badge-player {
            background-color: #87ceeb;
            color: #333;
        }

        .btn-small {
            padding: 6px 12px;
            background-color: #667eea;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .btn-small:hover {
            color: white;
            background-color: #5568d3;
        }
    </style>
@endsection
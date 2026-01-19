@extends('layouts.app')

@section('title', __('app.admin.statistics'))

@section('content')
    <div class="admin-container">
        <div class="page-header">
            <h1>{{ __('app.admin.system_statistics') }}</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← {{ __('app.app.back') }}</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                    <div class="stat-label">{{ __('app.admin.total_users') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">👑</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['adminCount'] }}</div>
                    <div class="stat-label">{{ __('app.admin.administrators') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎮</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['playerCount'] }}</div>
                    <div class="stat-label">{{ __('app.admin.players') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['usersToday'] }}</div>
                    <div class="stat-label">{{ __('app.admin.users_today') }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📱</div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['activeToday'] }}</div>
                    <div class="stat-label">{{ __('app.admin.active_today') }}</div>
                </div>
            </div>
        </div>

        <div class="additional-stats">
            <h2>{{ __('app.admin.user_distribution') }}</h2>
            <div class="chart-container">
                <canvas id="roleChart"></canvas>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.users') }}" class="btn-primary">Перейти до управління користувачами</a>
        </div>
    </div>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            color: white;
            background-color: #5a6268;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 20px;
            align-items: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            min-width: 70px;
            text-align: center;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.95rem;
        }

        .additional-stats {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .additional-stats h2 {
            margin-top: 0;
            margin-bottom: 30px;
            color: #333;
        }

        .chart-container {
            max-width: 500px;
            margin: 0 auto;
        }

        .actions {
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('roleChart').getContext('2d');
        const roleChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Адміністратори', 'Гравці'],
                datasets: [{
                    data: [{{ $stats['adminCount'] }}, {{ $stats['playerCount'] }}],
                    backgroundColor: [
                        'rgba(255, 215, 0, 0.8)',
                        'rgba(135, 206, 235, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 215, 0, 1)',
                        'rgba(135, 206, 235, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endsection
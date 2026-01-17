<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Football Manager 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #1e3a5f;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .sidebar {
            background: var(--primary);
            color: white;
            min-height: 100vh;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: var(--success);
        }
        .main-content {
            background: white;
            margin: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .club-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .player-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 15px;
        }
        .player-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .badge-rating {
            font-size: 18px;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: bold;
        }
        .badge-rating.high { background: var(--success); color: white; }
        .badge-rating.medium { background: var(--warning); color: white; }
        .badge-rating.low { background: var(--danger); color: white; }
        .table-hover tbody tr:hover {
            background: #f3f4f6;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }
        .stat-box strong {
            display: block;
            font-size: 28px;
            color: var(--primary);
            margin: 10px 0;
        }
        .stat-box small {
            color: #6b7280;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
                <div class="text-center mb-30" style="padding: 20px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <h5 class="mb-2">⚽ FM 2026</h5>
                    <small>Football Manager</small>
                </div>

                @if(session()->has('user_id'))
                    <nav class="nav flex-column">
                        <a class="nav-link" href="/dashboard">
                            <i class="bi bi-house-fill"></i> Дашбоард
                        </a>
                        <a class="nav-link" href="{{ route('club.overview') }}">
                            <i class="bi bi-shield"></i> Клуб
                        </a>
                        <a class="nav-link" href="{{ route('club.players') }}">
                            <i class="bi bi-people-fill"></i> Гравці
                        </a>
                        <a class="nav-link" href="{{ route('matches.fixtures') }}">
                            <i class="bi bi-calendar-event"></i> Матчі
                        </a>
                        <a class="nav-link" href="{{ route('matches.league-table') }}">
                            <i class="bi bi-bar-chart-fill"></i> Таблиця
                        </a>
                        <a class="nav-link" href="{{ route('transfers.market') }}">
                            <i class="bi bi-currency-dollar"></i> Трансфери
                        </a>
                        <a class="nav-link" href="{{ route('finances.index') }}">
                            <i class="bi bi-wallet2"></i> Фінанси
                        </a>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.2);">
                        <a class="nav-link" href="/logout">
                            <i class="bi bi-box-arrow-right"></i> Вихід
                        </a>
                    </nav>
                @endif
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Помилка!</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>✓ Успіх!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>✗ Помилка!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Football Manager 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/4b5357df72.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --primary: #1e3a5f;
            --success: #FFFFFF;
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
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-left-color: var(--success);
        }

        .main-content {
            background: rgba(255, 255, 255, 0.65);
            margin: 20px;
            border-radius: 14px;
            padding: 30px;
            backdrop-filter: blur(1px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 18px;

            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .player-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .player-rating {
            min-width: 44px;
            height: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            font-weight: 700;
            font-size: 16px;

            color: white;
        }

        .player-rating[data-rating^="9"],
        .player-rating[data-rating^="8"] {
            background: #10b981;
        }

        .player-rating[data-rating^="7"],
        .player-rating[data-rating^="6"] {
            background: #f59e0b;
        }

        .player-rating[data-rating^="5"],
        .player-rating[data-rating^="4"],
        .player-rating[data-rating^="3"],
        .player-rating[data-rating^="2"],
        .player-rating[data-rating^="1"] {
            background: #ef4444;
        }

        .badge-rating {
            font-size: 18px;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: bold;
        }

        .badge-rating.high {
            background: var(--success);
            color: black;
        }

        .badge-rating.medium {
            background: var(--warning);
            color: white;
        }

        .badge-rating.low {
            background: var(--danger);
            color: white;
        }

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

        .fm-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 12px 18px;

            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            border: 1px solid rgba(255, 255, 255, 0.35);

            box-shadow:
                0 6px 18px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        .fm-user {
            display: flex;
            align-items: center;
            gap: 8px;

            font-weight: 500;
            color: #1f2937;
        }

        .fm-user i {
            font-size: 20px;
            color: #2563eb;
        }

        .fm-lang-switch {
            display: flex;
            gap: 6px;
        }

        .fm-lang-btn {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .fm-lang-btn:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        .fm-lang-btn.active {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .pagination .page-link {
            color: #1e3a5f;
            border-radius: 6px;
            min-width: 40px;
            text-align: center;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .pagination .page-item.active .page-link {
            background: #1e3a5f;
            border-color: #1e3a5f;
            color: #fff;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
                <div class="text-center mb-30" style="padding: 20px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                    <h5 class="mb-2">FMs 2026</h5>
                    <small>Football Manager</small>
                </div>
                <div class="fm-topbar mb-3">
                    <div class="fm-user">
                        <i class="bi bi-person-circle"></i>
                        <span>
                            {{ session('username') ?? 'Manager' }}
                        </span>
                    </div>

                    <div class="fm-lang-switch">
                        <button class="fm-lang-btn lang-btn" data-lang="ua" {{ session('language', 'ua') === 'ua' ? 'style=\'background: #2563eb; color: #ffffff; border-color: #2563eb;\'' : '' }}>UA</button>
                        <button class="fm-lang-btn lang-btn" data-lang="en" {{ session('language', 'ua') === 'en' ? 'style=\'background: #2563eb; color: #ffffff; border-color: #2563eb;\'' : '' }}>EN</button>
                    </div>
                </div>

                @if(session()->has('user_id'))
                    <nav class="nav flex-column">
                        <a class="nav-link" href="/dashboard">
                            <i class="bi bi-house-fill"></i> {{ __('app.nav.dashboard') }}
                        </a>
                        <a class="nav-link" href="{{ route('club.overview') }}">
                            <i class="bi bi-shield"></i> {{ __('app.nav.club') }}
                        </a>
                        <a class="nav-link" href="{{ route('club.players') }}">
                            <i class="bi bi-people-fill"></i> {{ __('app.nav.players') }}
                        </a>
                        <a class="nav-link" href="{{ route('matches.fixtures') }}">
                            <i class="bi bi-calendar-event"></i> {{ __('app.nav.matches') }}
                        </a>
                        <a class="nav-link" href="{{ route('matches.league-table') }}">
                            <i class="bi bi-bar-chart-fill"></i> {{ __('app.nav.table') }}
                        </a>
                        <a class="nav-link" href="{{ route('transfers.market') }}">
                            <i class="bi bi-currency-dollar"></i> {{ __('app.nav.transfers') }}
                        </a>
                        <a class="nav-link" href="{{ route('finances.index') }}">
                            <i class="bi bi-wallet2"></i> {{ __('app.nav.finances') }}
                        </a>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.2);">
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; padding: 12px 20px; cursor: pointer; text-align: left;">
                                <i class="bi bi-box-arrow-right"></i> {{ __('app.nav.logout') }}
                            </button>
                        </form>
                    </nav>
                @endif
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ __('app.alert.error') }}</strong>
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
                            <strong>✓ {{ __('app.alert.success') }}</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>✗ {{ __('app.alert.error') }}</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const language = this.getAttribute('data-lang');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                console.log('Changing language to:', language);
                console.log('CSRF Token:', csrfToken);

                fetch(`/set-language/${language}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            document.querySelectorAll('.lang-btn').forEach(button => {
                                button.classList.remove('active');
                                button.style.background = 'rgba(255, 255, 255, 0.6)';
                                button.style.color = '#374151';
                                button.style.borderColor = 'rgba(255, 255, 255, 0.4)';
                            });
                            this.classList.add('active');
                            this.style.background = '#2563eb';
                            this.style.color = '#ffffff';
                            this.style.borderColor = '#2563eb';

                            console.log('Language changed, reloading...');
                            setTimeout(() => location.reload(), 500);
                        }
                    })
                    .catch(error => console.error('Fetch Error:', error));
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
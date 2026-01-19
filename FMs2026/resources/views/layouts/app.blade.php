<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FMs 2026 - Football Manager') - Football Manager 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }

        a {
            color: #667eea;
            text-decoration: none;
        }

        a:hover {
            color: #5568d3;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-nav {
            background: white;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-bottom: 3px solid #667eea;
        }

        .admin-nav-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .admin-logo {
            font-size: 1.3rem;
            font-weight: bold;
            color: #667eea;
        }

        .admin-nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .admin-nav-links a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .admin-nav-links a:hover,
        .admin-nav-links a.active {
            color: #667eea;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-user-info {
            text-align: right;
        }

        .admin-username {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        .admin-role {
            font-size: 0.85rem;
            color: #999;
        }

        .admin-logout {
            background-color: #e74c3c;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .admin-logout:hover {
            background-color: #c0392b;
            color: white;
        }

        .container-main {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            min-height: calc(100vh - 200px);
        }

        .sidebar-admin {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .sidebar-admin-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: #999;
        }

        .sidebar-admin-menu {
            list-style: none;
        }

        .sidebar-admin-menu li {
            margin-bottom: 8px;
        }

        .sidebar-admin-menu a {
            color: #666;
            text-decoration: none;
            display: block;
            padding: 10px 12px;
            border-radius: 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-admin-menu a:hover,
        .sidebar-admin-menu a.active {
            background-color: #f0f4ff;
            color: #667eea;
        }

        .sidebar-admin-menu i {
            font-size: 1.1rem;
            min-width: 20px;
            text-align: center;
        }

        .content-admin {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 0.9rem;
            margin-top: 40px;
        }

        .fm-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            background: grey;
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
            background: grey;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .fm-lang-btn:hover {
            background: darkgrey;
        }

        @media (max-width: 768px) {
            .container-main {
                grid-template-columns: 1fr;
            }

            .sidebar-admin {
                display: none;
            }

            .admin-nav-links {
                flex-wrap: wrap;
                gap: 10px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="admin-nav">
        <div class="admin-nav-inner">
            <div class="admin-logo">FMs 2026</div>
            <div class="admin-nav-links">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i> {{ __('app.admin.dashboard') }}
                </a>
                <a href="{{ route('admin.users') }}"
                    class="{{ Route::currentRouteName() === 'admin.users' ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> {{ __('app.admin.users') }}
                </a>
                <a href="{{ route('admin.statistics') }}"
                    class="{{ Route::currentRouteName() === 'admin.statistics' ? 'active' : '' }}">
                    <i class="bi bi-graph-up"></i> {{ __('app.admin.statistics') }}
                </a>
            </div>
            <div class="admin-user-menu">
                <div class="fm-lang-switch">
                    <button class="fm-lang-btn lang-btn" data-lang="ua" {{ session('language', 'ua') === 'ua' ? 'style=\'background: #2563eb; color: #ffffff; border-color: #2563eb;\'' : '' }}>UA</button>
                    <button class="fm-lang-btn lang-btn" data-lang="en" {{ session('language', 'ua') === 'en' ? 'style=\'background: #2563eb; color: #ffffff; border-color: #2563eb;\'' : '' }}>EN</button>
                </div>
                <div class="admin-user-info">
                    <div class="admin-username">{{ session('username') }}</div>
                    <div class="admin-role">👑 {{ __('app.admin.administrator') }}</div>
                </div>
                <form action="/logout" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="admin-logout">{{ __('app.admin.logout') }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-main">

        <div class="sidebar-admin">
            <div class="sidebar-admin-title">{{ __('app.admin.navigation') }}</div>
            <ul class="sidebar-admin-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
                        <i class="bi bi-graph-up-arrow"></i> {{ __('app.admin.dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}"
                        class="{{ Route::currentRouteName() === 'admin.users' ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> {{ __('app.admin.users') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.statistics') }}"
                        class="{{ Route::currentRouteName() === 'admin.statistics' ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i> {{ __('app.admin.statistics') }}
                    </a>
                </li>
            </ul>

            <div class="sidebar-admin-title" style="margin-top: 30px;">{{ __('app.admin.game') }}</div>
            <ul class="sidebar-admin-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-controller"></i> {{ __('app.admin.return_to_game') }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="content-admin">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-circle"></i> {{ __('app.admin.error') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-check-circle"></i> {{ __('app.admin.success') }}</strong>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-x-circle"></i> {{ __('app.admin.error') }}</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Football Manager Simulator. {{ __('app.admin.admin_panel') }}</p>
    </footer>

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
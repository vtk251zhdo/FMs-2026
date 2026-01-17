<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f4f4; }
        header { background:#111; color:#fff; padding:15px; }
        nav a { color:#fff; margin-right:15px; text-decoration:none; }
        .container { padding:30px; }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="/">Головна</a>
        <a href="/dashboard">Dashboard</a>
        <a href="/players">Гравці</a>
        <a href="/clubs">Клуби</a>
        <a href="/matches">Матчі</a>
        <a href="/transfers">Трансфери</a>
        <a href="/tournaments">Турніри</a>
        <a href="/login">Вхід</a>
    </nav>
</header>

<div class="container">
    @yield('content')
</div>

</body>
</html>

@extends('layouts.game')

@section('title', 'Дашбоард')

@section('content')
<div class="club-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">Вітаємо у Football Manager 2026! ⚽</h1>
            <p class="mb-1"><strong>Менеджер клубу:</strong> {{ $career->club->ClubName }}</p>
            <p class="mb-0"><strong>Поточний сезон:</strong> {{ $career->season->StartDate->format('Y') }} | {{ $career->season->StartDate->format('d.m.Y') }} - {{ $career->season->EndDate->format('d.m.Y') }}</p>
        </div>
        <div class="col-md-4 text-end">
            <h2 style="color: var(--success);">${{ number_format($career->club->Budget, 0) }}</h2>
            <p>Бюджет клубу</p>
        </div>
    </div>
</div>

<div class="row mt-30">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-2">⚙️</h3>
                <h5>Керування</h5>
                <p class="text-muted">Адмініструйте клуб</p>
                <a href="{{ route('club.overview') }}" class="btn btn-primary w-100">
                    До клубу
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-2">⚽</h3>
                <h5>Матчі</h5>
                <p class="text-muted">Переглядайте матчі</p>
                <a href="{{ route('matches.fixtures') }}" class="btn btn-primary w-100">
                    До матчів
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-2">💰</h3>
                <h5>Фінанси</h5>
                <p class="text-muted">Управління бюджетом</p>
                <a href="{{ route('finances.index') }}" class="btn btn-primary w-100">
                    До фінансів
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-30">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Наступні матчі</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <tbody>
                        @forelse($career->club->homeMatches()->whereNull('ScoreHome')->take(3)->get() as $match)
                        <tr>
                            <td>
                                <strong>{{ $match->homeClub->ClubName }}</strong> vs {{ $match->awayClub->ClubName }}
                                <br>
                                <small class="text-muted">{{ $match->MatchDate->format('d/m/Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center py-3">Немає матчів</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Статистика команди</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <p><small>Гравці:</small> <strong>{{ $career->club->players()->count() }}</strong></p>
                        <p><small>Тренери:</small> <strong>{{ $career->club->coaches()->count() }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p><small>Середній рейтинг:</small> <strong>{{ round($career->club->players()->avg('Rating') ?? 0, 1) }}/10</strong></p>
                        <p><small>Баланс:</small> <strong style="color: var(--success);">${{ number_format($career->club->Budget, 0) }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-primary mt-30" role="alert">
    <h5 class="alert-heading">💡 Порада</h5>
    <p class="mb-0">Розпочніть з перегляду вашого складу, встановіть тактику та готуйтесь до матчів. Слідкуйте за своїм бюджетом і виконуйте трансферні угоди для покращення команди!</p>
</div>

@endsection

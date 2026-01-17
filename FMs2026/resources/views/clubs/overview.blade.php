@extends('layouts.game')

@section('title', 'Огляд клубу')

@section('content')
<div class="club-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">{{ $club->ClubName }}</h1>
            <p class="mb-1"><small>{{ $club->City }}, {{ $club->Country }}</small></p>
            <p class="mb-0"><strong>Стадіон:</strong> {{ $club->Stadium }}</p>
        </div>
        <div class="col-md-4 text-end">
            <h3 style="color: var(--success);">Бюджет: $ {{ number_format($club->Budget, 0, ',', ' ') }}</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-black">
                <h5 class="mb-0">Сезон</h5>
            </div>
            <div class="card-body">
                @if($userClub && $userClub->season)
                <p><strong>Період:</strong> {{ $userClub->season->StartDate->format('d.m.Y') }} - {{ $userClub->season->EndDate->format('d.m.Y') }}</p>
                @if($userClub->season->tournament)
                <p><strong>Турнір:</strong> {{ $userClub->season->tournament->TournamentName }}</p>
                <p><strong>Рівень:</strong> {{ $userClub->season->tournament->Level }}</p>
                @endif
                @else
                <p class="text-muted">Сезон не вибраний</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-black">
                <h5 class="mb-0">Склад</h5>
            </div>
            <div class="card-body">
                <p><strong>Гравці:</strong> {{ count($players) }}</p>
                <p><strong>Тренери:</strong> {{ count($coaches) }}</p>
                @if(count($players) > 0)
                <p><strong>Середній рейтинг:</strong> <strong>{{ number_format($players->avg('Rating'), 1) }}/10</strong></p>
                <p><strong>Загальна вартість:</strong> $ {{ number_format($players->sum('Value'), 0, ',', ' ') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="btn-group" role="group">
            <a href="{{ route('club.players') }}" class="btn btn-outline-primary">
                <i class="bi bi-people"></i> Гравці
            </a>
            <a href="{{ route('club.coaches') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-badge"></i> Тренери
            </a>
            <a href="{{ route('transfers.market') }}" class="btn btn-outline-success">
                <i class="bi bi-shop"></i> Трансферний ринок
            </a>
            <a href="{{ route('finances.index') }}" class="btn btn-outline-warning">
                <i class="bi bi-wallet2"></i> Фінанси
            </a>
        </div>
    </div>
</div>

<style>
.club-header {
    background: linear-gradient(135deg, rgba(100, 200, 255, 0.2), rgba(100, 100, 200, 0.2));
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 5px solid var(--primary);
}

.card {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: black;
}

.card-header {
    background: rgba(0, 0, 0, 0.3) !important;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

.btn-group .btn {
    margin: 2px;
}
            </div>
        </div>
    </div>
</div>

<div class="row mt-30">
    <div class="col-md-6">
        <a href="{{ route('club.players') }}" class="btn btn-primary btn-lg w-100">
            <i class="bi bi-people-fill"></i> Керування гравцями
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('club.coaches') }}" class="btn btn-info btn-lg w-100">
            <i class="bi bi-person-badge"></i> Тренери
        </a>
    </div>
</div>
@endsection

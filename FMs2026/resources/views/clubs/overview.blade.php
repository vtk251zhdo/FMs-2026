@extends('layouts.game')

@section('title', __('app.club.overview'))

@section('content')
    <div class="club-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">{{ $club->ClubName }}</h1>
                <p class="mb-1"><small>{{ $club->City }}, {{ $club->Country }}</small></p>
                <p class="mb-0"><strong>{{ __('app.club.stadium') }}:</strong> {{ $club->Stadium }}</p>
            </div>
            <div class="col-md-4 text-end">
                <h3 style="color: var(--success);">{{ __('app.finances.budget') }}: $ {{ number_format($club->Budget, 0, ',', ' ') }}</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('app.club.season') }}</h5>
                </div>
                <div class="card-body">
                    @if($userClub && $userClub->season)
                        <p><strong>{{ __('app.club.period') }}:</strong> {{ $userClub->season->StartDate->format('d.m.Y') }} -
                            {{ $userClub->season->EndDate->format('d.m.Y') }}</p>
                        @if($userClub->season->tournament)
                            <p><strong>{{ __('app.club.tournament') }}:</strong> {{ $userClub->season->tournament->TournamentName }}</p>
                            <p><strong>{{ __('app.club.level') }}:</strong> {{ $userClub->season->tournament->Level }}</p>
                        @endif
                    @else
                        <p class="text-muted">{{ __('app.club.season_not_selected') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('app.club.squad') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('app.dashboard.players') }}</strong> {{ count($players) }}</p>
                    <p><strong>{{ __('app.dashboard.coaches') }}</strong> {{ count($coaches) }}</p>
                    @if(count($players) > 0)
                        <p><strong>{{ __('app.club.avg_rating') }}</strong>
                            <strong>{{ number_format($players->avg('Rating'), 1) }}/10</strong></p>
                        <p><strong>{{ __('app.club.total_value') }}:</strong> $ {{ number_format($players->sum('Value'), 0, ',', ' ') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="btn-group fm-btn-group" role="group">
                <a href="{{ route('club.players') }}" class="fm-btn fm-btn-primary">
                    <i class="bi bi-people"></i>
                    <span>{{ __('app.nav.players') }}</span>
                </a>

                <a href="{{ route('club.coaches') }}" class="fm-btn fm-btn-primary">
                    <i class="bi bi-person-badge"></i>
                    <span>{{ __('app.club.coaches') }}</span>
                </a>

                <a href="{{ route('transfers.market') }}" class="fm-btn fm-btn-success">
                    <i class="bi bi-shop"></i>
                    <span>{{ __('app.transfers.transfer_market') }}</span>
                </a>

                <a href="{{ route('finances.index') }}" class="fm-btn fm-btn-warning">
                    <i class="bi bi-wallet2"></i>
                    <span>{{ __('app.nav.finances') }}</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        .club-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid var(--primary);
            color: white;
        }

        .card {
            background: rgba(255, 255, 255);
            color: black;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-group .btn {
            margin: 2px;
        }

        </div></div></div></div>.fm-btn-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .fm-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 10px 18px;
            border-radius: 10px;

            font-weight: 500;
            font-size: 14px;
            text-decoration: none;

            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #1f2937;

            box-shadow:
                0 6px 18px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);

            transition: all 0.2s ease;
            margin-right: 15px;
        }

        .fm-btn i {
            font-size: 16px;
        }

        .fm-btn:hover {
            transform: translateY(-2px);
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.18);
            text-decoration: none;
        }

        .fm-btn-primary {
            border-left: 4px solid #2563eb;
        }

        .fm-btn-success {
            border-left: 4px solid #10b981;
        }

        .fm-btn-warning {
            border-left: 4px solid #f59e0b;
        }

        .fm-btn.active {
            background: rgba(255, 255, 255, 0.75);
        }

<div class="row mt-30"><div class="col-md-6"><a href="{{ route('club.players') }}" class="btn btn-primary btn-lg w-100"><i class="bi bi-people-fill"></i>Керування гравцями </a></div><div class="col-md-6"><a href="{{ route('club.coaches') }}" class="btn btn-info btn-lg w-100"><i class="bi bi-person-badge"></i>Тренери </a></div></div>@endsection
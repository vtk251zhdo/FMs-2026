@extends('layouts.game')

@section('title', __('app.dashboard.welcome'))

@section('content')
    <div class="club-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">{{ __('app.dashboard.welcome') }}</h1>
                <p class="mb-1"><strong>{{ __('app.dashboard.club_manager') }}</strong> {{ $career->club->ClubName }}</p>
                <p class="mb-0"><strong>{{ __('app.dashboard.season') }}</strong>
                    {{ $career->season->StartDate->format('Y') }} | {{ $career->season->StartDate->format('d.m.Y') }} -
                    {{ $career->season->EndDate->format('d.m.Y') }}</p>
            </div>
            <div class="col-md-4 text-end">
                <h2 style="color: var(--success);">${{ number_format($career->club->Budget, 0) }}</h2>
                <p>{{ __('app.dashboard.budget') }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-30">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-2"><i class="fa-solid fa-list-check"></i></h3>
                    <h5>{{ __('app.dashboard.management') }}</h5>
                    <p class="text-muted">{{ __('app.dashboard.manage_club') }}</p>
                    <a href="{{ route('club.overview') }}" class="btn w-100"
                        style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%); color: white;">
                        {{ __('app.dashboard.to_club') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-2"><i class="fa-solid fa-futbol"></i></h3>
                    <h5>{{ __('app.dashboard.matches') }}</h5>
                    <p class="text-muted">{{ __('app.dashboard.view_matches') }}</p>
                    <a href="{{ route('matches.fixtures') }}" class="btn w-100"
                        style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%); color: white;">
                        {{ __('app.dashboard.to_matches') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="mb-2"><i class="fa-solid fa-sack-dollar"></i></h3>
                    <h5>{{ __('app.dashboard.finances') }}</h5>
                    <p class="text-muted">{{ __('app.dashboard.budget_management') }}</p>
                    <a href="{{ route('finances.index') }}" class="btn w-100"
                        style="background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%); color: white;">
                        {{ __('app.dashboard.to_finances') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-30">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">{{ __('app.dashboard.upcoming_matches') }}</h5>
                </div>
                <div class="card-body p-0">
                    @forelse($upcomingMatches as $match)
                        <div class="border-bottom p-3" style="border-color: #e0e0e0;">
                            <div class="row align-items-center">
                                <div class="col-5 text-end">
                                    <p class="mb-0"><strong
                                            style="font-size: 0.95rem;">{{ $match->homeClub->ClubName ?? '—' }}</strong></p>
                                    <small class="text-muted">{{ __('app.matches.home') }}</small>
                                </div>

                                <div class="col-2 text-center">
                                    @if($match->Status === 'Finished')
                                        <h5 class="mb-0">{{ $match->ScoreHome }} : {{ $match->ScoreAway }}</h5>
                                    @else
                                        <p class="mb-0 text-muted">{{ __('app.matches.vs') }}</p>
                                    @endif
                                </div>

                                <div class="col-5">
                                    <p class="mb-0"><strong
                                            style="font-size: 0.95rem;">{{ $match->awayClub->ClubName ?? '—' }}</strong></p>
                                    <small class="text-muted">{{ __('app.matches.away') }}</small>
                                </div>
                            </div>
                            <div style="margin-top: 8px;">
                                <small class="text-muted">
                                    {{ $match->MatchDate ? \Carbon\Carbon::parse($match->MatchDate)->format('d.m.Y H:i') : __('app.matches.date_not_set') }}
                                </small>
                                <span class="badge bg-secondary float-end"
                                    style="font-size: 0.7rem;">{{ $match->getStatusText() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center py-3">
                            {{ __('app.dashboard.no_matches') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('app.dashboard.team_stats') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p><small>{{ __('app.dashboard.players') }}</small>
                                <strong>{{ $career->club->players()->count() }}</strong></p>
                            <p><small>{{ __('app.dashboard.coaches') }}</small>
                                <strong>{{ $career->club->coaches()->count() }}</strong></p>
                        </div>
                        <div class="col-6">
                            <p><small>{{ __('app.dashboard.avg_rating') }}</small>
                                <strong>{{ round($career->club->players()->avg('Rating') ?? 0, 1) }}/10</strong></p>
                            <p><small>{{ __('app.dashboard.budget') }}</small> <strong
                                    style="color: black;">${{ number_format($career->club->Budget, 0) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-primary mt-30" role="alert">
        <h5 class="alert-heading">💡 {{ __('app.dashboard.tip') }}</h5>
        <p class="mb-0">{{ __('app.dashboard.tip_text') }}</p>
    </div>

@endsection
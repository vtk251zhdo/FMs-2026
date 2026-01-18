@extends('layouts.game-2')

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="mb-4">{{ __('app.matches.title') }}</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <h4>{{ $match->homeClub->ClubName }}</h4>
                                <p class="text-muted">{{ $match->homeClub->City }}, {{ $match->homeClub->Country }}</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <h2 class="display-4">
                                    {{ $match->ScoreHome ?? '-' }}
                                    <span class="text-muted">:</span>
                                    {{ $match->ScoreAway ?? '-' }}
                                </h2>
                                <p class="text-muted small">
                                    @if($match->ScoreHome !== null)
                                        <strong>{{ $match->getResult() }}</strong>
                                    @else
                                        <em>{{ __('app.matches.pending') }}</em>
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-4 text-center">
                                <h4>{{ $match->awayClub->ClubName }}</h4>
                                <p class="text-muted">{{ $match->awayClub->City }}, {{ $match->awayClub->Country }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ $match->homeClub->ClubName }} {{ __('app.matches.squad') }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @forelse($match->homeClub->players()->orderBy('Number')->get() as $player)
                                        <li class="mb-2">
                                            <span class="badge badge-primary">{{ $player->Number }}</span>
                                            <strong>{{ $player->FullName }}</strong>
                                            <small class="text-muted">({{ $player->Position }})</small>
                                            <br>
                                            <small>{{ __('app.player.rating') }}:
                                                <strong>{{ $player->Rating }}/10</strong></small>
                                        </li>
                                    @empty
                                        <li class="text-muted">{{ __('app.club.no_players') }}</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ $match->awayClub->ClubName }} {{ __('app.matches.squad') }}</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    @forelse($match->awayClub->players()->orderBy('Number')->get() as $player)
                                        <li class="mb-2">
                                            <span class="badge badge-primary">{{ $player->Number }}</span>
                                            <strong>{{ $player->FullName }}</strong>
                                            <small class="text-muted">({{ $player->Position }})</small>
                                            <br>
                                            <small>{{ __('app.player.rating') }}:
                                                <strong>{{ $player->Rating }}/10</strong></small>
                                        </li>
                                    @empty
                                        <li class="text-muted">{{ __('app.club.no_players') }}</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if($match->ScoreHome !== null)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{ __('app.matches.statistics') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ $match->homeClub->ClubName }}</h6>
                                    @php
                                        $homeStats = $match->stats()
                                            ->whereIn('PlayerID', $match->homeClub->players()->pluck('PlayerID'))
                                            ->get();
                                    @endphp
                                    <ul class="list-unstyled small">
                                        <li>{{ __('app.player.goals') }}: <strong>{{ $homeStats->sum('Goals') }}</strong></li>
                                        <li>{{ __('app.player.assists') }}: <strong>{{ $homeStats->sum('Assists') }}</strong>
                                        </li>
                                        <li>{{ __('app.player.yellow_cards') }}:
                                            <strong>{{ $homeStats->sum('YellowCards') }}</strong></li>
                                        <li>{{ __('app.player.red_cards') }}: <strong>{{ $homeStats->sum('RedCards') }}</strong>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ $match->awayClub->ClubName }}</h6>
                                    @php
                                        $awayStats = $match->stats()
                                            ->whereIn('PlayerID', $match->awayClub->players()->pluck('PlayerID'))
                                            ->get();
                                    @endphp
                                    <ul class="list-unstyled small">
                                        <li>{{ __('app.player.goals') }}: <strong>{{ $awayStats->sum('Goals') }}</strong></li>
                                        <li>{{ __('app.player.assists') }}: <strong>{{ $awayStats->sum('Assists') }}</strong>
                                        </li>
                                        <li>{{ __('app.player.yellow_cards') }}:
                                            <strong>{{ $awayStats->sum('YellowCards') }}</strong></li>
                                        <li>{{ __('app.player.red_cards') }}: <strong>{{ $awayStats->sum('RedCards') }}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
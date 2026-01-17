@extends('layouts.game')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">Match Details</h1>
            
            <!-- Match Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Home Team -->
                        <div class="col-md-4 text-center">
                            <h4>{{ $match->homeClub->ClubName }}</h4>
                            <p class="text-muted">{{ $match->homeClub->City }}, {{ $match->homeClub->Country }}</p>
                        </div>
                        
                        <!-- Score -->
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
                                    <em>Pending</em>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Away Team -->
                        <div class="col-md-4 text-center">
                            <h4>{{ $match->awayClub->ClubName }}</h4>
                            <p class="text-muted">{{ $match->awayClub->City }}, {{ $match->awayClub->Country }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Match Details -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ $match->homeClub->ClubName }} Squad</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @forelse($match->homeClub->players()->orderBy('Number')->get() as $player)
                                    <li class="mb-2">
                                        <span class="badge badge-primary">{{ $player->Number }}</span>
                                        <strong>{{ $player->FullName }}</strong>
                                        <small class="text-muted">({{ $player->Position }})</small>
                                        <br>
                                        <small>Rating: <strong>{{ $player->Rating }}/10</strong></small>
                                    </li>
                                @empty
                                    <li class="text-muted">No players</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ $match->awayClub->ClubName }} Squad</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @forelse($match->awayClub->players()->orderBy('Number')->get() as $player)
                                    <li class="mb-2">
                                        <span class="badge badge-primary">{{ $player->Number }}</span>
                                        <strong>{{ $player->FullName }}</strong>
                                        <small class="text-muted">({{ $player->Position }})</small>
                                        <br>
                                        <small>Rating: <strong>{{ $player->Rating }}/10</strong></small>
                                    </li>
                                @empty
                                    <li class="text-muted">No players</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($match->ScoreHome !== null)
            <!-- Match Statistics -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Match Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>{{ $match->homeClub->ClubName }}</h6>
                            @php
                                $homeStats = $match->stats()->where('TeamID', $match->HomeClubID)->get();
                            @endphp
                            <ul class="list-unstyled small">
                                <li>Goals: <strong>{{ $homeStats->sum('Goals') }}</strong></li>
                                <li>Assists: <strong>{{ $homeStats->sum('Assists') }}</strong></li>
                                <li>Yellow Cards: <strong>{{ $homeStats->sum('YellowCards') }}</strong></li>
                                <li>Red Cards: <strong>{{ $homeStats->sum('RedCards') }}</strong></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>{{ $match->awayClub->ClubName }}</h6>
                            @php
                                $awayStats = $match->stats()->where('TeamID', $match->AwayClubID)->get();
                            @endphp
                            <ul class="list-unstyled small">
                                <li>Goals: <strong>{{ $awayStats->sum('Goals') }}</strong></li>
                                <li>Assists: <strong>{{ $awayStats->sum('Assists') }}</strong></li>
                                <li>Yellow Cards: <strong>{{ $awayStats->sum('YellowCards') }}</strong></li>
                                <li>Red Cards: <strong>{{ $awayStats->sum('RedCards') }}</strong></li>
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

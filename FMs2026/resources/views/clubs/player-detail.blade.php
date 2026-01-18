@extends('layouts.game')

@section('title', __('app.player.details'))

@section('content')
    <div class="mb-30">
        <a href="{{ route('club.players') }}" class="btn btn-sm btn-outline-secondary">← {{ __('app.back') }}</a>
        <h2>{{ $player->FullName }}</h2>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('app.player.personal_info') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('app.player.position') }}:</strong> {{ $player->Position }} (#{{ $player->Number }})
                    </p>
                    <p><strong>{{ __('app.player.age') }}:</strong> {{ $player->Age }} {{ __('app.player.years') }}</p>
                    <p><strong>{{ __('app.player.nationality') }}:</strong> {{ $player->Nationality }}</p>
                    <p><strong>{{ __('app.player.rating') }}:</strong> {{ $player->Rating }}/10</p>
                    <p><strong>{{ __('app.transfers.market_value') }}:</strong> ${{ number_format($player->Value, 0) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{ __('app.player.season_stats') }}</h5>
                </div>
                <div class="card-body">
                    @php
                        $stats = $player->stats()->get();
                        $goals = $stats->sum('Goals');
                        $assists = $stats->sum('Assists');
                    @endphp

                    <p><strong>{{ __('app.matches.played') }}:</strong> {{ count($stats) }}</p>
                    <p><strong>{{ __('app.player.goals') }}:</strong> {{ $goals }}</p>
                    <p><strong>{{ __('app.player.assists') }}:</strong> {{ $assists }}</p>
                    <p><strong>{{ __('app.player.yellow_cards') }}:</strong> {{ $stats->sum('YellowCards') }}</p>
                    <p><strong>{{ __('app.player.red_cards') }}:</strong> {{ $stats->sum('RedCards') }}</p>
                    <p><strong>{{ __('app.player.avg_rating') }}:</strong>
                        {{ number_format($stats->avg('Rating') ?? 0, 1) }}/10</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('app.transfers.sell') }}" class="btn btn-danger">
                <i class="bi bi-cash-coin"></i> {{ __('app.transfers.sell_player') }}
            </a>
        </div>
    </div>
@endsection
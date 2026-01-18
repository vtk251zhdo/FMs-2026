@extends('layouts.game-2')

@section('title', __('app.club.players_title'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-30">
        <h2>{{ __('app.club.players_title') }} - {{ $club->ClubName }}</h2>
        <a href="{{ route('transfers.market') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> {{ __('app.transfers.buy_player') }}
        </a>
    </div>

    <div class="row">
        @forelse($players as $player)
            <div class="col-md-6 col-lg-4" style="margin-bottom: 20px;">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $player->FullName }}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>{{ __('app.club.position') }}:</strong> {{ $player->Position }}<br>
                            <strong>{{ __('app.club.number') }}:</strong> {{ $player->Number }}<br>
                            <strong>{{ __('app.club.age') }}:</strong> {{ $player->Age }}<br>
                            <strong>{{ __('app.club.rating') }}:</strong>
                            @if($player->Rating >= 8.0)
                                <span class="badge bg-success">{{ $player->Rating }}/10</span>
                            @elseif($player->Rating >= 6.5)
                                <span class="badge bg-warning">{{ $player->Rating }}/10</span>
                            @else
                                <span class="badge bg-danger">{{ $player->Rating }}/10</span>
                            @endif
                        </p>
                        <p><strong>{{ __('app.club.value') }}:</strong> ${{ number_format($player->Value, 0) }}</p>

                        <div class="mt-3">
                            <a href="{{ route('club.player', $player->PlayerID) }}" class="btn btn-sm btn-outline-primary">
                                {{ __('app.transfers.details') }}
                            </a>
                            <a href="{{ route('transfers.sell') }}" class="btn btn-sm btn-outline-danger">
                                {{ __('app.transfers.sell') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> {{ __('app.transfers.no_players') }} <a
                        href="{{ route('transfers.market') }}">{{ __('app.transfers.purchase_players') }}</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
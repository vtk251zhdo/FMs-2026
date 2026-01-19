@extends('layouts.game-2')

@section('title', __('app.transfers.sell_players'))

@section('content')
    <div class="mb-30">
        <h2>{{ __('app.transfers.sell_players') }}</h2>
        <p class="text-muted">{{ __('app.finances.current_budget') }}:
            <strong>${{ number_format($club->Budget, 0, ',', ' ') }}</strong></p>
    </div>

    <div class="row">
        @forelse($players as $player)
            <div class="col-md-6 col-lg-4 mb-20">
                <div class="player-card">
                    <div class="d-flex justify-content-between align-items-start mb-10">
                        <div>
                            <h6 class="mb-1"><strong>{{ $player->FullName }}</strong></h6>
                            <small class="text-muted">{{ $player->Position }} (#{{ $player->Number }})</small>
                        </div>
                        <span class="badge-rating {{ $player->Rating >= 8 ? 'high' : 'medium' }}">
                            {{ $player->Rating }}
                        </span>
                    </div>

                    <p class="mb-10">
                        <strong>{{ __('app.transfers.current_value') }}:</strong><br>
                        ${{ number_format($player->Value, 0, ',', ' ') }}
                    </p>

                    <form method="POST" action="{{ route('transfers.sell-player', $player->PlayerID) }}" class="mb-10">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">{{ __('app.transfers.asking_price') }} ($)</label>
                            <input type="number" name="sell_price" class="form-control form-control-sm"
                                placeholder="{{ __('app.transfers.sell_price') }}" min="0" value="{{ $player->Value }}"
                                required>
                        </div>
                        <button class="btn btn-danger w-100 btn-sm" type="submit">{{ __('app.transfers.sell') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    {{ __('app.transfers.no_players_to_sell') }}
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-20">
        <a href="{{ route('transfers.market') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> {{ __('app.transfers.back_to_market') }}
        </a>
    </div>
@endsection
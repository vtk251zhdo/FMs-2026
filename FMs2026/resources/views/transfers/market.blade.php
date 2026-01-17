@extends('layouts.game')

@section('title', 'Трансфери - Ринок')

@section('content')
<div class="mb-30">
    <h2>Трансферний ринок</h2>
    <p class="text-muted">Баланс клубу: <strong>${{ number_format($club->Budget, 0, ',', ' ') }}</strong></p>
</div>

<div class="row">
    @forelse($players as $player)
    <div class="col-md-6 col-lg-4 mb-20">
        <div class="player-card">
            <div class="d-flex justify-content-between align-items-start mb-10">
                <div>
                    <h6 class="mb-1"><strong>{{ $player->FullName }}</strong></h6>
                    <small class="text-muted">{{ $player->Position }}</small>
                </div>
                <span class="badge-rating {{ $player->Rating >= 8 ? 'high' : 'medium' }}">
                    {{ $player->Rating }}
                </span>
            </div>

            <p class="mb-10"><strong>${{ number_format($player->Value, 0, ',', ' ') }}</strong></p>

            <form method="POST" action="{{ route('transfers.buy', $player->PlayerID) }}" class="mb-10">
                @csrf
                <div class="input-group">
                    <input type="number" name="offer_amount" class="form-control form-control-sm" 
                           placeholder="Пропозиція ($)" min="0" value="{{ $player->Value }}" required>
                    <button class="btn btn-primary btn-sm" type="submit">Купити</button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Гравців на ринку не знайдено</div>
    </div>
    @endforelse
</div>

{{ $players->links() }}

<div class="mt-40">
    <a href="{{ route('transfers.sell') }}" class="btn btn-lg btn-danger">
        <i class="bi bi-cash-coin"></i> Продати гравців
    </a>
</div>
@endsection

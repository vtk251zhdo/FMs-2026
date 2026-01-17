@extends('layouts.game')

@section('title', 'Деталі гравця')

@section('content')
<div class="mb-30">
    <a href="{{ route('club.players') }}" class="btn btn-sm btn-outline-secondary">← Назад</a>
    <h2>{{ $player->FullName }}</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Особиста інформація</h5>
            </div>
            <div class="card-body">
                <p><strong>Позиція:</strong> {{ $player->Position }} (#{{ $player->Number }})</p>
                <p><strong>Вік:</strong> {{ $player->Age }} років</p>
                <p><strong>Національність:</strong> {{ $player->Nationality }}</p>
                <p><strong>Рейтинг:</strong> {{ $player->Rating }}/10</p>
                <p><strong>Ринкова вартість:</strong> ${{ number_format($player->Value, 0) }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Статистика сезону</h5>
            </div>
            <div class="card-body">
                @php
                $stats = $player->stats()->get();
                $goals = $stats->sum('Goals');
                $assists = $stats->sum('Assists');
                @endphp
                
                <p><strong>Матчів:</strong> {{ count($stats) }}</p>
                <p><strong>Голів:</strong> {{ $goals }}</p>
                <p><strong>Передач:</strong> {{ $assists }}</p>
                <p><strong>Жовтих карток:</strong> {{ $stats->sum('YellowCards') }}</p>
                <p><strong>Червоних карток:</strong> {{ $stats->sum('RedCards') }}</p>
                <p><strong>Середній рейтинг за матч:</strong> {{ number_format($stats->avg('Rating') ?? 0, 1) }}/10</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('transfers.sell') }}" class="btn btn-danger">
            <i class="bi bi-cash-coin"></i> Продати гравця
        </a>
    </div>
</div>
@endsection

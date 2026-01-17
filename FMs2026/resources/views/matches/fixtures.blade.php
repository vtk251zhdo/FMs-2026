@extends('layouts.game')

@section('title', 'Матчі - Графік')

@section('content')

@php
    // Захист від ділення на нуль і некоректних даних
    $totalRounds = max(1, (int) ($season->TotalRounds ?? 0));
    $currentRound = max(1, min((int) ($season->CurrentRound ?? 1), $totalRounds));
    $progress = ($currentRound / $totalRounds) * 100;
@endphp

<div class="mb-30">
    <h2 class="mb-20">
        Графік матчів – Раунд {{ $currentRound }} / {{ $totalRounds }}
    </h2>

    <div class="progress mb-20" style="height: 25px;">
        <div
            class="progress-bar bg-success"
            role="progressbar"
            style="width: {{ $progress }}%;"
            aria-valuenow="{{ $currentRound }}"
            aria-valuemin="0"
            aria-valuemax="{{ $totalRounds }}"
        >
            {{ round($progress) }}%
        </div>
    </div>
</div>

<div class="row">
    @forelse($matches as $match)
        <div class="col-md-6 mb-20">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Раунд {{ $match->Round }}</strong>
                        <span class="badge bg-info">
                            {{ $match->getStatusText() }}
                        </span>
                    </div>
                    <small class="text-muted">
                        {{ $match->MatchDate
                            ? \Carbon\Carbon::parse($match->MatchDate)->format('d.m.Y H:i')
                            : 'Дата не визначена'
                        }}
                    </small>
                </div>

                <div class="card-body p-15">
                    <div class="row align-items-center">
                        <div class="col-5 text-end">
                            <p class="mb-0">
                                <strong>{{ $match->homeClub->ClubName ?? '—' }}</strong>
                            </p>
                            <small class="text-muted">Дома</small>
                        </div>

                        <div class="col-2 text-center">
                            @if($match->Status === 'Finished')
                                <h4 class="mb-0">
                                    {{ $match->HomeGoals }} : {{ $match->AwayGoals }}
                                </h4>
                            @else
                                <p class="mb-0 text-muted">vs</p>
                            @endif
                        </div>

                        <div class="col-5">
                            <p class="mb-0">
                                <strong>{{ $match->awayClub->ClubName ?? '—' }}</strong>
                            </p>
                            <small class="text-muted">Гості</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <a
                        href="{{ route('matches.detail', $match->MatchID) }}"
                        class="btn btn-sm btn-primary w-100"
                    >
                        Деталі матчу
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <strong>Матчів не знайдено</strong><br>
                Календар ще не згенеровано або сезон не розпочато.
            </div>
        </div>
    @endforelse
</div>

@endsection
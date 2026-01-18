@extends('layouts.game')

@section('title', __('app.finances.title'))

@section('content')
    <div class="mb-30">
        <h2>{{ __('app.finances.report') }} - {{ $club->ClubName }}</h2>
    </div>

    <div class="stats-grid">
        <div class="stat-box ">
            <small>{{ __('app.finances.current_budget') }}</small>
            <strong style="color: var(--success);">${{ number_format($currentBudget, 0, ',', ' ') }}</strong>
            <small>{{ __('app.finances.available_funds') }}</small>
        </div>
        <div class="stat-box">
            <small>{{ __('app.finances.transfer_spending') }}</small>
            <strong style="color: var(--danger);">${{{ number_format($transferSpending, 0, ',', ' ') }}}</strong>
            <small>{{ __('app.finances.this_season') }}</small>
        </div>
        <div class="stat-box">
            <small>{{ __('app.finances.transfer_income') }}</small>
            <strong style="color: var(--success);">${{ number_format($transferIncome, 0, ',', ' ') }}</strong>
            <small>{{ __('app.finances.this_season') }}</small>
        </div>
        <div class="stat-box">
            <small>{{ __('app.finances.squad_value') }}</small>
            <strong style="color: white">${{ number_format($squadValue, 0, ',', ' ') }}</strong>
            <small>{{ __('app.finances.market_value') }}</small>
        </div>
    </div>

    <div class="row mt-30">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">{{ __('app.finances.transfer_activity') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-20">
                        <p class="mb-10"><strong>{{ __('app.finances.spending') }}:</strong>
                            ${{ number_format($transferSpending, 0, ',', ' ') }}</p>
                        <small class="text-muted">{{ __('app.finances.spent_on_purchases') }}</small>
                    </div>
                    <div class="mb-20">
                        <p class="mb-10"><strong>{{ __('app.finances.income') }}:</strong>
                            ${{ number_format($transferIncome, 0, ',', ' ') }}</p>
                        <small class="text-muted">{{ __('app.finances.received_from_sales') }}</small>
                    </div>
                    <div class="mb-0">
                        <p class="mb-10"><strong>{{ __('app.finances.net_spending') }}:</strong>
                            <span style="color: {{ $netSpending > 0 ? '#e74c3c' : '#2ecc71' }};">
                                ${{ number_format($netSpending, 0, ',', ' ') }}
                            </span>
                        </p>
                        <small class="text-muted">{{ __('app.finances.difference') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">{{ __('app.finances.recent_transfers') }}</h5>
                </div>
                <div class="card-body">
                    @forelse($recentTransfers->take(5) as $transfer)
                        <div class="mb-10 pb-10" style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                            <p class="mb-1"><strong>{{ $transfer->player->FullName }}</strong></p>
                            <small>
                                {{ $transfer->fromClub->ClubName }}
                                <i class="bi bi-arrow-right"></i>
                                {{ $transfer->toClub->ClubName }}
                            </small><br>
                            <small style="color: var(--success);">
                                ${{ number_format($transfer->TransferFee, 0, ',', ' ') }} -
                                {{ $transfer->TransferDate->format('d.m.Y') }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('app.finances.no_transfers') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-box strong {
            display: block;
            font-size: 24px;
            margin: 10px 0;
        }

        .card {
            background: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: black;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0f172a 100%);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        <div class="card"><div class="card-header bg-success text-white"><h5 class="mb-0">Фінансовий Статус</h5></div><div class="card-body">
        @if($currentBudget > $squadValue * 0.5)
            <p class="text-success"><i class="bi bi-check-circle"></i>Ваш клуб в хорошому фінансовому стані</p>
        @elseif($currentBudget > $squadValue * 0.25)
<p class="text-warning"><i class="bi bi-exclamation-triangle"></i>Слідкуйте за видатками</p>@else <p class="text-danger"><i class="bi bi-x-circle"></i>Обмежені фінансові ресурси</p>@endif </div></div></div></div>@endsection
@extends('layouts.game')

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="mb-4">{{ __('app.finances.budget_details') }}</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ __('app.finances.budget_status') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="text-muted">{{ __('app.finances.available_budget') }}</h6>
                                <h2 class="text-success">${{ number_format($club->Budget, 0) }}</h2>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ min(($club->Budget / 10000000) * 100, 100) }}%">
                                        <small>{{ round(min(($club->Budget / 10000000) * 100, 100), 1) }}%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">{{ __('app.club.squad_value') }}</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('app.player.total_value') }}</h6>
                        <h3>${{ number_format($squadValue ?? 0, 0) }}</h3>
                        <small class="text-muted">
                            <strong>{{ $club->players()->count() }}</strong> {{ __('app.club.players') }}
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">{{ __('app.transfers.activity') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-muted">{{ __('app.transfers.total_spent') }}</h6>
                            <h4 class="text-danger">${{ number_format($transferSpending ?? 0, 0) }}</h4>
                        </div>
                        <div>
                            <h6 class="text-muted">{{ __('app.transfers.total_earned') }}</h6>
                            <h4 class="text-success">${{ number_format($transferIncome ?? 0, 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">{{ __('app.transfers.recent') }}</h5>
            </div>
            <div class="card-body">
                @if($recentTransfers && count($recentTransfers) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('app.player.name') }}</th>
                                    <th>{{ __('app.transfers.type') }}</th>
                                    <th>{{ __('app.transfers.from') }}</th>
                                    <th>{{ __('app.transfers.to') }}</th>
                                    <th>{{ __('app.transfers.fee') }}</th>
                                    <th>{{ __('app.transfers.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransfers as $transfer)
                                    <tr>
                                        <td><strong>{{ $transfer->player->FullName }}</strong></td>
                                        <td>
                                            @if($transfer->FromClubID == $club->ClubID)
                                                <span class="badge badge-danger">{{ __('app.transfers.sale') }}</span>
                                            @else
                                                <span class="badge badge-success">Purchase</span>
                                            @endif
                                        </td>
                                        <td>{{ $transfer->fromClub->ClubName }}</td>
                                        <td>{{ $transfer->toClub->ClubName }}</td>
                                        <td>${{ number_format($transfer->TransferFee, 0) }}</td>
                                        <td>{{ $transfer->TransferDate->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3">No recent transfers</p>
                @endif
            </div>
        </div>
    </div>
@endsection
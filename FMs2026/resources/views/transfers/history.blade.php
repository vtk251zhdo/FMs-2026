@extends('layouts.game')

@section('title', __('app.transfers.history'))

@section('content')
    <div class="mb-30">
        <h2>{{ __('app.transfers.transfer_history') }}</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('app.player.name') }}</th>
                    <th>{{ __('app.transfers.from') }}</th>
                    <th>{{ __('app.transfers.to') }}</th>
                    <th>{{ __('app.transfers.fee') }}</th>
                    <th>{{ __('app.transfers.date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transfers as $transfer)
                    <tr>
                        <td><strong>{{ $transfer->player->FullName }}</strong></td>
                        <td>{{ $transfer->fromClub->ClubName ?? 'N/A' }}</td>
                        <td>{{ $transfer->toClub->ClubName ?? 'N/A' }}</td>
                        <td>${{ number_format($transfer->TransferFee, 0) }}</td>
                        <td>{{ $transfer->TransferDate->format('d.m.Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">{{ __('app.transfers.no_transfers') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $transfers->links() }}
@endsection
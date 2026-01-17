@extends('layouts.game')

@section('title', 'Історія трансфертів')

@section('content')
<div class="mb-30">
    <h2>Історія трансфертів</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Гравець</th>
                <th>З клубу</th>
                <th>До клубу</th>
                <th>Вартість</th>
                <th>Дата</th>
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
                <td colspan="5" class="text-center text-muted">Немає трансфертів</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $transfers->links() }}
@endsection

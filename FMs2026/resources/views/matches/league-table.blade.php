@extends('layouts.game')

@section('title', __('app.matches.league_table'))

@section('content')
    <div class="mb-30">
        <h2>
            {{ __('app.matches.table') }} {{ $season->tournament->TournamentName ?? __('app.matches.season') }}
        </h2>

        <p class="text-muted">
            {{ $season->StartDate?->format('d.m.Y') ?? '—' }}
            –
            {{ $season->EndDate?->format('d.m.Y') ?? __('app.matches.ongoing') }}
        </p>
    </div>

    <div class="table-responsive">
        <table class="league-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>{{ __('app.transfers.club') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.m') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.w') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.d') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.l') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.gf') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.ga') }}</th>
                    <th style="width: 70px;">{{ __('app.matches.gd') }}</th>
                    <th style="width: 50px;">{{ __('app.matches.p') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($table as $position => $entry)
                    <tr class="{{ ($entry['club']->ClubID ?? null) === ($currentClubId ?? null) ? 'highlight' : '' }}">
                        <td><strong>{{ $position + 1 }}</strong></td>

                        <td>
                            <strong>{{ $entry['club']->ClubName }}</strong><br>
                            <small class="text-muted">{{ $entry['club']->City }}</small>
                        </td>

                        <td>{{ $entry['matches'] }}</td>
                        <td><span class="badge bg-success">{{ $entry['wins'] }}</span></td>
                        <td><span class="badge bg-info">{{ $entry['draws'] }}</span></td>
                        <td><span class="badge bg-danger">{{ $entry['losses'] }}</span></td>
                        <td>{{ $entry['gf'] }}</td>
                        <td>{{ $entry['ga'] }}</td>
                        <td>{{ $entry['gd'] > 0 ? '+' : '' }}{{ $entry['gd'] }}</td>
                        <td><strong class="text-primary">{{ $entry['points'] }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            {{ __('app.matches.table_empty') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <style>
        .league-table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255);
            color: black;
        }

        .league-table thead {
            background: rgba(0, 0, 0, 0.4);
        }

        .league-table th {
            padding: 12px 8px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }

        .league-table td {
            padding: 10px 8px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .league-table tbody tr:hover {
            background: rgba(33, 23, 33, 0.1);
        }

        .league-table tbody tr.highlight {
            background: rgba(100, 200, 255, 0.2);
            border-left: 4px solid #64c8ff;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
@endsection
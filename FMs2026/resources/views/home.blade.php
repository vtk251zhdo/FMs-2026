@extends('layouts.game')

@section('title', 'Football Manager 2026')

@section('content')
<div class="club-header mb-30">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">Football Manager 2026 ⚽</h1>
            <p class="mb-0 text-muted">
                Керуйте клубом, трансферами, матчами та ведіть команду до перемог
            </p>
        </div>
    </div>
</div>

<div class="row justify-content-center mt-40">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body p-30">
                <h3 class="mb-15">🎮 Розпочати карʼєру</h3>
                <p class="text-muted mb-25">
                    Створіть власну футбольну історію та станьте легендарним менеджером
                </p>

                <a href="
                @if(!session()->has('user_id'))
                    /login
                @else
                    /start-game
                @endif
                " class="btn btn-success btn-lg w-100">
                    Грати
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

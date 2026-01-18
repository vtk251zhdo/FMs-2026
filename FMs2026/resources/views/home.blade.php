@extends('layouts.game')

@section('title', 'Football Manager 2026')

@section('content')
    <div class="club-header mb-30">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">{{ __('app.app.title') }}</h1>
                <p class="mb-0">
                    {{ __('app.app.subtitle') }}
                </p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-40">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body p-30">
                    <h3 class="mb-15">{{ __('app.app.start_career') }}</h3>
                    <p class="text-muted mb-25">
                        {{ __('app.app.career_description') }}
                    </p>

                    <a href="
                    @if(!session()->has('user_id'))
                        /login
                    @else
                        /start-game
                    @endif
                    " class="btn btn-success btn-lg w-100">
                        {{ __('app.app.play') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .club-header p {
        color: #ffffff;
    }
</style>
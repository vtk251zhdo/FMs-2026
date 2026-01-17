@extends('layouts.game')

@section('title', 'Вхід')

@section('content')
<div class="row justify-content-center mt-50">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Вхід у Football Manager</h4>
            </div>

            <div class="card-body p-30">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-15">
                        <label class="form-label">Логін</label>
                        <input name="username" class="form-control" required>
                    </div>

                    <div class="mb-20">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100">
                        Увійти
                    </button>
                </form>
            </div>

            <div class="card-footer text-center">
                <small>
                    Немає акаунту?
                    <a href="/register">Зареєструватися</a>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

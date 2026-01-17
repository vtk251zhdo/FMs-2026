@extends('layouts.game')

@section('title', 'Реєстрація')

@section('content')
<div class="row justify-content-center mt-50">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">Реєстрація менеджера</h4>
            </div>

            <div class="card-body p-30">
                <form method="POST" action="/register">
                    @csrf

                    <div class="mb-15">
                        <label class="form-label">Логін</label>
                        <input name="username" class="form-control" required>
                    </div>

                    <div class="mb-15">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" required>
                    </div>

                    <div class="mb-20">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100">
                        Зареєструватись
                    </button>
                </form>
            </div>

            <div class="card-footer text-center">
                <small>
                    Вже є акаунт?
                    <a href="/login">Увійти</a>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

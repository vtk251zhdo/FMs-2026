@extends('layouts.app')

@section('title', 'Реєстрація')

@section('content')
    <h2>Реєстрація менеджера</h2>

    <form method="POST" action="/register">
        @csrf
        <input name="username" placeholder="Логін"><br><br>
        <input name="email" placeholder="Email"><br><br>
        <input type="password" name="password" placeholder="Пароль"><br><br>
        <button>Зареєструватись</button>
    </form>
@endsection

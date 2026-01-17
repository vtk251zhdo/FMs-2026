@extends('layouts.app')

@section('title', 'Вхід')

@section('content')
    <h2>Вхід</h2>

    <form>
        <input type="text" placeholder="Логін"><br><br>
        <input type="password" placeholder="Пароль"><br><br>
        <button>Увійти</button>
    </form>

    <p><a href="/register">Створити акаунт</a></p>
@endsection

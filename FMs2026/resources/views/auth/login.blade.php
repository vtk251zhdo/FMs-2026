@extends('layouts.app')

@section('title', 'Вхід')

@section('content')
    <h2>Вхід</h2>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/login">
        @csrf
        <input name="username" placeholder="Логін"><br><br>
        <input type="password" name="password" placeholder="Пароль"><br><br>
        <button>Увійти</button>
    </form>

    <p style="margin-top:15px;">
        Немає акаунту?
        <a href="/register">Зареєструватися</a>
    </p>
@endsection

@extends('layouts.app')

@section('title', 'Реєстрація')

@section('content')
    <h2>Реєстрація менеджера</h2>

    <form>
        <input type="text" placeholder="Логін"><br><br>
        <input type="email" placeholder="Email"><br><br>
        <input type="password" placeholder="Пароль"><br><br>
        <button>Зареєструватись</button>
    </form>
@endsection

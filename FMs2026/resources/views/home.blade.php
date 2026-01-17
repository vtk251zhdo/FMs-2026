@extends('layouts.app')

@section('title', 'Football Manager')

@section('content')
    <h1>Football Manager</h1>
    <p>Керуйте клубом, трансферами та матчами</p>

    <a href="/login">
        <button style="padding:15px 30px; font-size:18px;">
            🎮 Грати
        </button>
    </a>

    {{-- тут ти потім додаси background image --}}
@endsection

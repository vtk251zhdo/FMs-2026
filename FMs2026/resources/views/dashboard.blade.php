@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p>Ласкаво просимо, менеджер!</p>

    <ul>
        <li><a href="/players">Гравці</a></li>
        <li><a href="/clubs">Клуби</a></li>
        <li><a href="/matches">Матчі</a></li>
        <li><a href="/transfers">Трансфери</a></li>
        <li><a href="/tournaments">Турніри</a></li>
    </ul>
@endsection

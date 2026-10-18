@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1>Привет, {{ auth()->user()->username }}</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1>Привет, {{ auth()->user()->username }}</h1>
    <p>Это личная база знаний Capsulify.</p>
@endsection

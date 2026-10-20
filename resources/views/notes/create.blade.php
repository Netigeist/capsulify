@extends('layouts.app')

@section('title', 'Создание заметки')

@section('content')
    <div class="page-header">
        <h1>Создание заметки</h1>
    </div>

    <form class="form" method="POST" action="{{ route('notes.store') }}">
        @csrf
        @include('notes._form', ['note' => null, 'submitText' => 'Создать'])
    </form>
@endsection

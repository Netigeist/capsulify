@extends('layouts.app')

@section('title', 'Изменение заметки')

@section('content')
    <div class="page-header">
        <h1>Изменение заметки</h1>
    </div>

    <form class="form" method="POST" action="{{ route('notes.update', $note) }}">
        @csrf
        @method('PUT')
        @include('notes._form', ['note' => $note, 'submitText' => 'Сохранить'])
    </form>
@endsection

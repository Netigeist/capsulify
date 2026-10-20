@extends('layouts.app')

@section('title', 'Новая категория')

@section('content')
    <div class="page-header">
        <h1>Новая категория</h1>
    </div>

    <form class="form" method="POST" action="{{ route('categories.store') }}">
        @csrf
        @include('categories._form', ['submitText' => 'Сохранить'])
    </form>
@endsection

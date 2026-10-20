@extends('layouts.app')

@section('title', 'Изменить категорию')

@section('content')
    <div class="page-header">
        <h1>Изменить категорию</h1>
    </div>

    <form class="form" method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('categories._form', ['category' => $category, 'submitText' => 'Обновить'])
    </form>
@endsection

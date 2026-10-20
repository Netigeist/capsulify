@extends('layouts.app')

@section('title', 'Загрузка файла')

@section('content')
    <div class="page-header">
        <h1>Загрузка файла</h1>
    </div>

    <form class="form" method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf

        <label>
            Файл (до 3 МБ: jpg, jpeg, png, gif, webp, pdf, docx)
            <input type="file" name="file" required>
        </label>

        @error('file')
            <p class="error">{{ $message }}</p>
        @enderror

        <div class="form-actions">
            <button type="submit" class="button">Загрузить</button>
            <a class="button secondary" href="{{ route('files.index') }}">Отмена</a>
        </div>
    </form>
@endsection

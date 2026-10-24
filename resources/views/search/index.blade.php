@extends('layouts.app')

@section('title', 'Поиск')

@section('content')
    <div class="page-header">
        <h1>Поиск</h1>
    </div>

    <form method="GET" action="{{ route('search') }}" class="search-form">
        <label>
            Запрос
            <input type="search" name="q" value="{{ $q }}" minlength="2" maxlength="255">
        </label>
        <button type="submit" class="button">Найти</button>
    </form>

    @error('q')
        <p class="error">{{ $message }}</p>
    @enderror

    @if ($q === '')
        <p class="empty">Введите поисковый запрос.</p>
    @elseif ($results->isEmpty())
        <p class="empty">Ничего не найдено.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Тип</th>
                    <th>Название</th>
                    <th>Создано</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td class="result-type">
                            @if ($result['type'] === 'note')
                                Заметка
                            @else
                                Файл
                            @endif
                        </td>
                        <td>{{ $result['title'] }}</td>
                        <td>{{ $result['created_at']->format('d.m.Y H:i') }}</td>
                        <td class="actions">
                            @if ($result['type'] === 'note')
                                <a class="button secondary" href="{{ route('notes.show', $result['id']) }}">Открыть</a>
                            @else
                                <a class="button secondary" href="{{ route('files.download', $result['id']) }}">Скачать</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials.pagination', ['paginator' => $results])
    @endif
@endsection

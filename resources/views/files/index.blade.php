@extends('layouts.app')

@section('title', 'Файлы')

@section('content')
    <div class="page-header">
        <h1>Файлы</h1>
        <a class="button" href="{{ route('files.create') }}">Загрузить файл</a>
    </div>

    <div class="toolbar">
        <span>Сортировка:</span>
        <a class="{{ $direction === 'desc' ? 'active' : '' }}"
            href="{{ route('files.index', ['direction' => 'desc']) }}">Сначала новые</a>
        <a class="{{ $direction === 'asc' ? 'active' : '' }}"
            href="{{ route('files.index', ['direction' => 'asc']) }}">Сначала старые</a>
    </div>

    @if ($files->isEmpty())
        <p class="empty">Файлов пока нет.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Имя файла</th>
                    <th>Загружен</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ $file->file_name }}</td>
                        <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions">
                            <a class="button secondary" href="{{ route('files.download', $file) }}">Скачать</a>
                            <form method="POST" action="{{ route('files.destroy', $file) }}" data-confirm="Удалить файл?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials.pagination', ['paginator' => $files])
    @endif
@endsection

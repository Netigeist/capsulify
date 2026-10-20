@extends('layouts.app')

@section('title', 'Заметки')

@section('content')
    <div class="page-header">
        <h1>Заметки</h1>
        <a class="button" href="{{ route('notes.create') }}">Создать заметку</a>
    </div>

    <form method="GET" action="{{ route('notes.index') }}" class="filter-form">
        <input type="hidden" name="direction" value="{{ $direction }}">
        <label>
            Категория
            <select name="category">
                <option value="">Все</option>
                <option value="none" @selected($category === 'none')>Без категории</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected((string) $category === (string) $cat->id)>{{ $cat->category_title }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="button secondary">Применить</button>
    </form>

    <div class="toolbar">
        <span>Сортировка:</span>
        <a class="{{ $direction === 'desc' ? 'active' : '' }}"
            href="{{ route('notes.index', $filterParams + ['direction' => 'desc']) }}">Сначала новые</a>
        <a class="{{ $direction === 'asc' ? 'active' : '' }}"
            href="{{ route('notes.index', $filterParams + ['direction' => 'asc']) }}">Сначала старые</a>
    </div>

    @if ($notes->isEmpty())
        <p class="empty">Заметок пока нет.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Файл</th>
                    <th>Срок</th>
                    <th>Выполнено</th>
                    <th>Создана</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td><a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a></td>
                        <td>{{ $note->category?->category_title ?? '—' }}</td>
                        <td>{{ $note->file?->file_name ?? '—' }}</td>
                        <td>{{ $note->due_date?->format('d.m.Y') ?? '—' }}</td>
                        <td>{{ $note->is_completed ? 'Да' : 'Нет' }}</td>
                        <td>{{ $note->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions">
                            <a class="button secondary" href="{{ route('notes.edit', $note) }}">Изменить</a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}"
                                data-confirm="Удалить заметку?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials.pagination', ['paginator' => $notes])
    @endif
@endsection

@extends('layouts.app')

@section('title', $note->title)

@section('content')
    <div class="page-header">
        <h1>{{ $note->title }}</h1>
        <div class="actions">
            <a class="button secondary" href="{{ route('notes.edit', $note) }}">Изменить</a>
            <a class="button secondary" href="{{ route('notes.index') }}">Назад</a>
        </div>
    </div>

    <dl class="meta">
        <div>
            <dt>Категория</dt>
            <dd>{{ $note->category?->category_title ?? '—' }}</dd>
        </div>
        <div>
            <dt>Файл</dt>
            <dd>
                @if ($note->file)
                    <a href="{{ route('files.download', $note->file) }}">{{ $note->file->file_name }}</a>
                @else
                    —
                @endif
            </dd>
        </div>
        <div>
            <dt>Срок</dt>
            <dd>{{ $note->due_date?->format('d.m.Y') ?? '—' }}</dd>
        </div>
        <div>
            <dt>Статус</dt>
            <dd>{{ $note->is_completed ? 'Выполнено' : 'В работе' }}</dd>
        </div>
        <div>
            <dt>Создана</dt>
            <dd>{{ $note->created_at->format('d.m.Y H:i') }}</dd>
        </div>
    </dl>

    <div class="note-content">{{ $note->content }}</div>
@endsection

@extends('layouts.app')

@section('title', 'Категории')

@section('content')
    <div class="page-header">
        <h1>Категории</h1>
        <a class="button" href="{{ route('categories.create') }}">Создать категорию</a>
    </div>

    <div class="toolbar">
        <span>Сортировка:</span>
        <a class="{{ $direction === 'desc' ? 'active' : '' }}"
            href="{{ route('categories.index', ['direction' => 'desc']) }}">Сначала новые</a>
        <a class="{{ $direction === 'asc' ? 'active' : '' }}"
            href="{{ route('categories.index', ['direction' => 'asc']) }}">Сначала старые</a>
    </div>

    @if ($categories->isEmpty())
        <p class="empty">Категорий пока нет.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Создана</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->category_title }}</td>
                        <td>{{ $category->created_at->format('d.m.Y H:i') }}</td>
                        <td class="actions">
                            <a class="button secondary" href="{{ route('categories.edit', $category) }}">Изменить</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                data-confirm="Удалить категорию?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('partials.pagination', ['paginator' => $categories])
    @endif
@endsection

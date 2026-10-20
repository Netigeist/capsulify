<div class="pagination">
    @if ($paginator->onFirstPage())
        <span class="disabled">Назад</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">Назад</a>
    @endif

    <span>Страница {{ $paginator->currentPage() }} из {{ $paginator->lastPage() }}</span>

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">Вперёд</a>
    @else
        <span class="disabled">Вперёд</span>
    @endif
</div>

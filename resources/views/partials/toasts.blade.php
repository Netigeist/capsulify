<div class="toast-stack" aria-live="polite" aria-atomic="true">
    @if (session('status'))
        <div class="toast toast-success" data-toast role="status">
            <div class="toast-content">{{ session('status') }}</div>
            <button class="toast-close" type="button" aria-label="Закрыть уведомление">&times;</button>
        </div>
    @endif
</div>

document.addEventListener('DOMContentLoaded', function () {
    var root = document.documentElement;
    var themeButtons = document.querySelectorAll('.theme-toggle');
    var shell = document.querySelector('.shell');
    var menuToggle = document.querySelector('.menu-toggle');

    var getCurrentTheme = function () {
        return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    };

    var setTheme = function (theme) {
        root.setAttribute('data-theme', theme);

        try {
            localStorage.setItem('theme', theme);
        } catch (e) {
        }

        themeButtons.forEach(function (button) {
            button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
            button.textContent = theme === 'dark' ? 'Светлая тема' : 'Тёмная тема';
        });
    };

    setTheme(getCurrentTheme());

    themeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            setTheme(getCurrentTheme() === 'dark' ? 'light' : 'dark');
        });
    });

    if (shell && menuToggle) {
        menuToggle.addEventListener('click', function () {
            var isOpen = shell.classList.toggle('nav-open');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    var modalBackdrop = document.getElementById('confirm-modal');
    var modalTitle = document.getElementById('confirm-title');
    var modalMessage = document.getElementById('confirm-description');
    var modalConfirmButton = document.querySelector('[data-modal-confirm]');
    var modalCancelButton = document.querySelector('[data-modal-cancel]');
    var modalCloseButton = document.querySelector('[data-modal-close]');
    var pendingForm = null;
    var lastFocusedElement = null;

    var getFocusableElements = function () {
        if (!modalBackdrop || modalBackdrop.hidden) {
            return [];
        }

        return Array.prototype.slice.call(
            modalBackdrop.querySelectorAll(
                'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
            )
        );
    };

    var closeModal = function () {
        if (!modalBackdrop) {
            return;
        }

        modalBackdrop.hidden = true;
        document.body.classList.remove('modal-open');
        pendingForm = null;

        if (modalConfirmButton) {
            modalConfirmButton.disabled = false;
        }

        if (modalCancelButton) {
            modalCancelButton.disabled = false;
        }

        if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
            lastFocusedElement.focus();
        }
    };

    var openConfirmModal = function (form) {
        if (!modalBackdrop || !modalTitle || !modalMessage || !modalConfirmButton || !modalCancelButton) {
            form.dataset.confirmReady = '1';
            form.submit();
            return;
        }

        pendingForm = form;
        lastFocusedElement = document.activeElement;

        modalTitle.textContent = form.dataset.confirmTitle || 'Подтверждение действия';
        modalMessage.textContent = form.dataset.confirm || 'Вы уверены?';
        modalConfirmButton.textContent = form.dataset.confirmSubmit || 'Подтвердить';
        modalCancelButton.textContent = form.dataset.confirmCancel || 'Отмена';

        modalBackdrop.hidden = false;
        document.body.classList.add('modal-open');
        modalCancelButton.focus();
    };

    document.addEventListener('submit', function (event) {
        var form = event.target;

        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (!form.dataset.confirm) {
            return;
        }

        if (form.dataset.confirmReady === '1') {
            return;
        }

        event.preventDefault();
        openConfirmModal(form);
    });

    if (modalConfirmButton) {
        modalConfirmButton.addEventListener('click', function () {
            if (!pendingForm) {
                closeModal();
                return;
            }

            modalConfirmButton.disabled = true;

            if (modalCancelButton) {
                modalCancelButton.disabled = true;
            }

            pendingForm.dataset.confirmReady = '1';

            if (typeof pendingForm.requestSubmit === 'function') {
                pendingForm.requestSubmit();
            } else {
                pendingForm.submit();
            }
        });
    }

    if (modalCancelButton) {
        modalCancelButton.addEventListener('click', closeModal);
    }

    if (modalCloseButton) {
        modalCloseButton.addEventListener('click', closeModal);
    }

    if (modalBackdrop) {
        modalBackdrop.addEventListener('mousedown', function (event) {
            if (event.target === modalBackdrop) {
                closeModal();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (!modalBackdrop || modalBackdrop.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            closeModal();
            return;
        }

        if (event.key !== 'Tab') {
            return;
        }

        var focusable = getFocusableElements();

        if (focusable.length === 0) {
            event.preventDefault();
            return;
        }

        var first = focusable[0];
        var last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
            return;
        }

        if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    var toasts = document.querySelectorAll('[data-toast]:not([data-toast-initialized])');

    toasts.forEach(function (toast, index) {
        toast.setAttribute('data-toast-initialized', '1');

        var closeButton = toast.querySelector('.toast-close');
        var timeoutId = null;

        var hideToast = function () {
            toast.classList.add('is-hiding');

            window.setTimeout(function () {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 200);
        };

        var scheduleHide = function () {
            timeoutId = window.setTimeout(hideToast, 5000 + index * 250);
        };

        if (closeButton) {
            closeButton.addEventListener('click', function () {
                if (timeoutId) {
                    window.clearTimeout(timeoutId);
                }

                hideToast();
            });
        }

        scheduleHide();
    });
});
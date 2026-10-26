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

    document.addEventListener('submit', function (event) {
        var form = event.target;
        var message = form.dataset ? form.dataset.confirm : null;

        if (message && !window.confirm(message)) {
            event.preventDefault();
        }
    });
});
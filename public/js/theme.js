(function () {
    var theme = 'light';

    try {
        var stored = localStorage.getItem('theme');

        if (stored === 'dark' || stored === 'light') {
            theme = stored;
        } else {
            localStorage.setItem('theme', theme);
        }
    } catch (e) {
        theme = 'light';
    }

    document.documentElement.setAttribute('data-theme', theme);
})();
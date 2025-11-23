import './bootstrap';

// Dark mode handler for non-Filament pages
// Check localStorage (set by Filament) or system preference
(function() {
    const html = document.documentElement;

    // Check if Filament has set a theme preference
    const filamentTheme = localStorage.getItem('theme');

    if (filamentTheme === 'dark') {
        html.classList.add('dark');
    } else if (filamentTheme === 'light') {
        html.classList.remove('dark');
    } else {
        // No Filament preference - check system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }
})();

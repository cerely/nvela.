//for theme//

const themeRadios = document.querySelectorAll('input[name="theme"]');

    function updateTheme(theme) {
    document.documentElement.setAttribute("data-theme", theme);
    }

    themeRadios.forEach(radio => {
    radio.addEventListener("change", e => {
        const theme = e.target.value;

        if (!document.startViewTransition) {
        updateTheme(theme);
        return;
        }

        // Animated transition (Chrome/Edge support)
        document.startViewTransition(() => updateTheme(theme));
    });
    });

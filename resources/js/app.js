import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

function updateThemeToggleButtons() {
    document.querySelectorAll("[data-theme-toggle]").forEach((button) => {
        const isDark = document.documentElement.classList.contains("dark");
        const icon = isDark
            ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM10 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM4.22 4.22a1 1 0 011.42 0L6.64 5.22a1 1 0 11-1.42 1.42L4.22 5.64a1 1 0 010-1.42zM14.36 14.36a1 1 0 011.42 0l1 1a1 1 0 11-1.42 1.42l-1-1a1 1 0 010-1.42zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zM16 10a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zM4.22 15.78a1 1 0 010-1.42l1-1a1 1 0 111.42 1.42l-1 1a1 1 0 01-1.42 0zM14.36 5.64a1 1 0 010-1.42l1-1a1 1 0 111.42 1.42l-1 1a1 1 0 01-1.42 0zM10 6a4 4 0 100 8 4 4 0 000-8z"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" clip-rule="evenodd"/></svg>';
        const label = isDark ? "Light Mode" : "Dark Mode";
        button.innerHTML = `<span class="inline-flex items-center gap-2">${icon}<span>${label}</span></span>`;
    });
}

function applyThemePreference() {
    const storedTheme = localStorage.getItem("theme");
    const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)",
    ).matches;
    const useDark = storedTheme ? storedTheme === "dark" : prefersDark;
    document.documentElement.classList.toggle("dark", useDark);
    updateThemeToggleButtons();
}

window.toggleDarkMode = function () {
    const isDark = document.documentElement.classList.toggle("dark");
    localStorage.setItem("theme", isDark ? "dark" : "light");
    updateThemeToggleButtons();
};

window.addEventListener("DOMContentLoaded", () => {
    applyThemePreference();
});

Alpine.start();

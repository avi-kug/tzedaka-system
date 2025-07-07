function toggleColumn(columnClass, show) {//הצגת והסתרת עמודות בטבלה
    const displayStyle = show ? '' : 'none';

    document.querySelectorAll('th.' + columnClass).forEach(th => {
        th.style.display = displayStyle;
    });

    document.querySelectorAll('td.' + columnClass).forEach(td => {
        td.style.display = displayStyle;
    });
}

function saveColumnPreferences() {
    const prefs = {};
    document.querySelectorAll('.toggle-column').forEach(checkbox => {
        const key = checkbox.getAttribute('data-column');
        prefs[key] = checkbox.checked;
    });
    localStorage.setItem('columnPrefs', JSON.stringify(prefs));
}

function loadColumnPreferences() {
    const prefs = JSON.parse(localStorage.getItem('columnPrefs') || '{}');

    document.querySelectorAll('.toggle-column').forEach(checkbox => {
        const key = checkbox.getAttribute('data-column');
        if (key in prefs) {
            checkbox.checked = prefs[key];
        }
        const columnClass = 'col-' + key;
        toggleColumn(columnClass, checkbox.checked);
    });
}

// בעת שינוי checkbox – הפעל ועדכן localStorage
document.querySelectorAll('.toggle-column').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const columnClass = 'col-' + checkbox.getAttribute('data-column');
        toggleColumn(columnClass, checkbox.checked);
        saveColumnPreferences();
    });
});

// בעת טעינה – החזר מצב שמור
window.addEventListener('DOMContentLoaded', () => {
    loadColumnPreferences();
});
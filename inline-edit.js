/*document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('td[data-id][data-column]').forEach(td => {
        td.addEventListener('dblclick', () => {
            const originalValue = td.textContent.trim();
            const input = document.createElement('input');
            input.type = 'text';
            input.value = originalValue;
            input.className = 'form-control';
            td.textContent = '';
            td.appendChild(input);
            input.focus();

            input.addEventListener('blur', () => {
                td.textContent = originalValue;
            });

            input.addEventListener('keydown', async e => {
                if (e.key === 'Enter') {
                    const id = td.dataset.id;
                    const column = td.dataset.column;
                    const value = input.value;

                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('column', column);
                    formData.append('value', value);

                    try {
                        const res = await fetch('update_cell.php', {
                            method: 'POST',
                            body: formData
                        });

                        if (res.ok) {
                            td.textContent = value;
                        } else {
                            td.textContent = originalValue;
                            alert('שגיאה בעדכון הנתון.');
                        }
                    } catch {
                        td.textContent = originalValue;
                        alert('שגיאה בתקשורת עם השרת.');
                    }
                }
            });
        });
    });
});*/

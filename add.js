// טיפול בהוספה ב-AJAX
const addForm = document.getElementById('addForm');
if (addForm) {
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(addForm);

        fetch(addForm.action, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // סגור את המודל (Bootstrap 5)
                const modalEl = document.getElementById('addFormModal');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.hide();

                addForm.reset();

                // הצג alert רק אחרי שהמודל נסגר בפועל
                modalEl.addEventListener('hidden.bs.modal', function handler() {
                    alert('הנתון נוסף בהצלחה!');
                    // מסיר את ה-listener כדי שלא יופעל שוב
                    modalEl.removeEventListener('hidden.bs.modal', handler);
                });
            } else {
                alert(data.error || 'שגיאה בהוספה');
            }
        })
        .catch(() => alert('שגיאה בשליחה'));
    });
}
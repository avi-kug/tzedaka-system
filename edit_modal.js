function openEditModal(id) {
    const body = document.getElementById('editModalBody');
    body.innerHTML = 'טוען...';

    fetch(`load_edit_form.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            body.innerHTML = html;
            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        })
        .catch(() => {
            body.innerHTML = 'שגיאה בטעינת טופס העריכה';
        });
}


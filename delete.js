function deleteRow(id) {
    if (!confirm('האם אתה בטוח שברצונך למחוק?')) return;

    fetch('delete.php', {  
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + encodeURIComponent(id)
    }).then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('אירעה שגיאה במחיקה');
        }
    });
}

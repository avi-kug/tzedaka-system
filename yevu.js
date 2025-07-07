document.getElementById("excel_file").addEventListener("change", function () {
  if (this.files.length > 0) {
    document.getElementById("importExcelForm").dispatchEvent(new Event("submit")); // ✅ שליחה אוטומטית
  }
});

document.getElementById("importExcelForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  document.getElementById("importError").innerHTML = ''; // ניקוי הודעות קודמות

  fetch("import_excel.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.text())
    .then(html => {
      if (html.startsWith("שגיאה:")) {
        document.getElementById("importError").innerHTML = html; // ✅ הצג שגיאה בלי לסגור
        return;
      }
      document.getElementById("mappingArea").innerHTML = html;

      const form = document.getElementById("mappingForm");
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData2 = new FormData(form);
        document.getElementById("importError").innerHTML = ''; // ניקוי הודעות קודמות

        fetch("import_excel_save.php", {
          method: "POST",
          body: formData2
        })
          .then(res => res.text())
          .then(msg => {
            if (msg.startsWith("שגיאה:")) {
              document.getElementById("importError").innerHTML = msg; // ✅ שגיאה בלי סגירה
              return;
            }

            // הצלחה
            window.successMessage = msg;
            const importModal = bootstrap.Modal.getInstance(document.getElementById("importModal"));
            importModal.hide();
          });
      });
    });
});

document.getElementById("importModal").addEventListener("hidden.bs.modal", function () {
  if (window.successMessage) {
    alert(window.successMessage);
    refreshTable();
    window.successMessage = null;
  }
});

function refreshTable() {
  fetch("get_table.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("get_table").innerHTML = html;
    });
}
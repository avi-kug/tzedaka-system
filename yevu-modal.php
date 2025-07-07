<!-- מודאל יבוא אקסל -->
<div class="modal fade" id="importModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">יבוא קובץ אקסל</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="importModalBody">
        <form id="importExcelForm" enctype="multipart/form-data">
          <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" class="form-control mb-3" required>
          <button type="submit" class="btn btn-primary d-none">טען קובץ</button> <!-- ✅ מוסתר -->
          <div class="mb-3">
            <label class="form-label">בחר פעולה עבור נתונים קיימים:</label>
            <select name="import_mode" class="form-select" required>
              <option value="insert_update">הוספת חדשים + עדכון קיימים</option>
              <option value="update_only">עדכון קיימים בלבד</option>
              <option value="insert_only">הוספת חדשים בלבד</option>
            </select>
          </div>
        </form>
        <div id="mappingArea" class="mt-4"></div>
        <div id="importError" class="text-danger mt-2 fw-bold"></div> <!-- ✅ תיבת שגיאות -->
      </div>
    </div>
  </div>
</div>
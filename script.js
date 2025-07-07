document.addEventListener("DOMContentLoaded", function () {
    // משתנים
    const selectAll = document.getElementById("selectAll");// סימון/ביטול סימון הכל
    const checkboxes = document.querySelectorAll(".rowCheckbox");// צ'קבוקסים של שורות
    const deleteBtn = document.getElementById("deleteSelectedBtn");// כפתור מחיקת שורות נבחרות
    const counter = document.getElementById("selectedCount");   // ספירת שורות מסומנות
    const searchForm = document.getElementById("searchForm");   // טופס חיפוש
    const totalRows = document.getElementById("totalRows"); // ספירת סה"כ שורות
    
    const url = new URL(window.location);
    const search = url.searchParams.get("search");


   

    // אם החיפוש ריק או שווה רק לרווחים – מנקה את הכתובת
    if (search !== null && search.trim() === "") 
        url.searchParams.delete("search");
        window.history.replaceState({}, document.title, url.pathname);
    





    // עדכון כפתור מחיקה וספירה
    function toggleButton() {
        if (deleteBtn) {
            deleteBtn.disabled = ![...checkboxes].some(cb => cb.checked);
        }
    }
    function updateCount() {
        const count = document.querySelectorAll(".rowCheckbox:checked").length;
        if (counter) {
            counter.textContent = count > 0 ? `מסומנות ${count} שורות` : '';
        }
    }
    function updateTotalRows() {
    const rows = document.querySelectorAll(".rowCheckbox");
    if (totalRows) {
        totalRows.textContent = `סה"כ שורות: ${rows.length}`;
    }
}

    // סימון/ביטול סימון לכולם
    if (selectAll) {
        selectAll.addEventListener("change", () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            toggleButton();
            updateCount();
        });
    }

    // שינוי בכל צ'קבוקס
    checkboxes.forEach(cb => {
        cb.addEventListener("change", () => {
            toggleButton();
            updateCount();
        });
    });

    // מחיקת רשומות נבחרות באמצעות AJAX
    if (deleteBtn) {
        deleteBtn.addEventListener("click", async () => {
            if (!confirm("האם אתה בטוח שברצונך למחוק את השורות המסומנות?")) return;
            const selectedCheckboxes = document.querySelectorAll(".rowCheckbox:checked");
            const ids = Array.from(selectedCheckboxes).map(cb => cb.value);

            if (ids.length === 0) return;

            const formData = new FormData();
            ids.forEach(id => formData.append('selected_ids[]', id));

            try {
                const response = await fetch('delete_multiple.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // מחיקת השורות מהטבלה
                    selectedCheckboxes.forEach(cb => cb.closest('tr').remove());
                    toggleButton();
                    updateCount();
                    alert('השורות נמחקו בהצלחה.');
                } else {
                    alert('אירעה שגיאה בעת המחיקה.');
                }
            } catch (err) {
                alert('תקלה בתקשורת עם השרת.');
                console.error(err);
            }
        });
    }

    // מחיקת שורה בודדת
    document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.addEventListener("click", function () {
            const rowId = this.getAttribute("data-id");
            if (!confirm("האם אתה בטוח שברצונך למחוק?")) return;

            fetch("delete_single.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + encodeURIComponent(rowId)
            })
            .then(res => {
                if (res.ok) {
                    this.closest("tr").remove();
                    toggleButton();
                    updateCount();
                } else {
                    alert("שגיאה במחיקה");
                }
            });
        });
    });

    // טיפול בטופס חיפוש: אם ריק – מעבר ל-view.php נקי
    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            const searchInput = searchForm.querySelector("input[name='search']");
            if (searchInput && searchInput.value.trim() === "") {
                e.preventDefault();
                window.location.href = "view.php";
            }
        });
    }

    // הסתרת הודעת הצלחה אוטומטית (אם יש)
    setTimeout(() => {
        const msg = document.getElementById("success-message");
        if (msg) {
            msg.classList.add("hide");
            setTimeout(() => msg.remove(), 500);
        }
    }, 1500);

    // עדכון ראשוני
    toggleButton();
    updateCount();
    updateTotalRows();
});
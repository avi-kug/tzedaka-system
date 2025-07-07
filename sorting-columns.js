document.querySelectorAll('th.sortable span.sortable-text').forEach(function(span) {
    span.addEventListener('click', function() {
        let th = span.parentElement;
        let table = th.closest('table');
        let tbody = table.querySelector('tbody');
        let rows = Array.from(tbody.querySelectorAll('tr'));
        let colIndex = Array.from(th.parentNode.children).indexOf(th);
        let isAsc = th.classList.toggle('asc');
        th.classList.toggle('desc', !isAsc);

        // הסר אייקון מיון מכל שאר הכותרות
        table.querySelectorAll('th.sortable').forEach(function(otherTh) {
            if (otherTh !== th) {
                otherTh.classList.remove('asc', 'desc');
            }
        });

        rows.sort(function(a, b) {
            let aText = a.children[colIndex].innerText.trim();
            let bText = b.children[colIndex].innerText.trim();
            let aNum = parseFloat(aText.replace(/,/g, ''));
            let bNum = parseFloat(bText.replace(/,/g, ''));
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAsc ? aNum - bNum : bNum - aNum;
            }
            return isAsc ? aText.localeCompare(bText, 'he') : bText.localeCompare(aText, 'he');
        });

        rows.forEach(function(row) {
            tbody.appendChild(row);
        });
    });
});

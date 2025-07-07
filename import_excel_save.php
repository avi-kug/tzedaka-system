<?php
include 'db.php';
include 'fields.php';

if (isset($_POST['map'])) {
    $map = $_POST['map'];
    $mode = $_POST['import_mode'] ?? 'insert_update';

    if (in_array('', $map, true)) {
        exit("שגיאה: יש עמודות שלא מולאו במיפוי. יש לבחור שדה לכל עמודה.");
    }

    if (!file_exists('tmp_import.json')) {
        exit("שגיאה: קובץ זמני לא נמצא.");
    }

    $rows = json_decode(file_get_contents('tmp_import.json'), true);
    @unlink('tmp_import.json');

    if (!$rows) {
        exit("שגיאה: נתונים לא תקינים.");
    }

    $inserted = 0;
    $updated = 0;

    $fieldsToInsert = array_unique(array_values(array_filter($map)));

    for ($i = 1; $i < count($rows); $i++) {
        $row = $rows[$i];
        $values = [];

        foreach ($fieldsToInsert as $dbField) {
            $colIdx = array_search($dbField, $map);
            $values[$dbField] = $row[$colIdx] ?? '';
        }

        $id = $values['id_number'] ?? null;
        if (!$id) continue;

        // בדוק אם קיימת רשומה עם ת"ז זהה
        $check = $pdo->prepare("SELECT * FROM people WHERE id_number = ?");
        $check->execute([$id]);
        $existing = $check->fetch(PDO::FETCH_ASSOC);
        $exists = $existing ? true : false;

        if ($mode === 'insert_only' && $exists) continue;
        if ($mode === 'update_only' && !$exists) continue;

        if ($exists && $mode !== 'insert_only') {
            // השוואת ערכים: האם יש שינוי כלשהו?
            $changed = false;
            foreach ($values as $key => $val) {
                if (!isset($existing[$key]) || trim($existing[$key]) !== trim($val)) {
                    $changed = true;
                    break;
                }
            }

            if ($changed) {
                $updateFields = array_map(fn($f) => "$f = ?", array_keys($values));
                $stmt = $pdo->prepare("UPDATE people SET ".implode(",", $updateFields)." WHERE id_number = ?");
                $stmt->execute([...array_values($values), $id]);
                $updated++;
            }
        } elseif (!$exists && $mode !== 'update_only') {
            // הוספה
            $columns = implode(",", array_keys($values));
            $placeholders = implode(",", array_fill(0, count($values), "?"));
            $stmt = $pdo->prepare("INSERT INTO people ($columns) VALUES ($placeholders)");
            $stmt->execute(array_values($values));
            $inserted++;
        }
    }

    echo "✅ נוספו $inserted, עודכנו $updated";
} else {
    echo "שגיאה: לא נשלח מיפוי.";
}

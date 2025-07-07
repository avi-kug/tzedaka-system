<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>העלאת PDF למיון</title>
</head>
<body>
    <h1>בחר קובץ PDF למיון לפי "לכבוד"</h1>
    <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept="application/pdf" required>
        <button type="submit">העלה ומיין</button>
    </form>
</body>
</html>

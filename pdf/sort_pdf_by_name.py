import sys
import pdfplumber
import PyPDF2
import io
import re
import traceback

# תמיכה בעברית בפלט
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')


def extract_name_from_page(page, i):
    text = page.extract_text()
    print(f"\n--- עמוד {i+1} ---")
    print(text)

    if text and "דובכל" in text:
        lines = text.split("\n")
        for idx, line in enumerate(lines):
            if "דובכל" in line:
                # נסה לקחת את השורה שאחרי
                if idx + 1 < len(lines):
                    name_line = lines[idx + 1].strip()
                else:
                    # אם אין שורה אחרי, קח את מה שנשאר בשורה עצמה
                    name_line = line.replace("דובכל", "").strip()

                # שמור רק אותיות עבריות ורווחים
                name = re.sub(r'[^א-ת ]', '', name_line)
                print(f"נמצא שם: {name}")
                return name

    return "zzzz"  # כדי למיין בסוף


def sort_pdf_by_name(input_path, output_path):
    with pdfplumber.open(input_path) as pdf:
        pages_with_names = []
        for i, page in enumerate(pdf.pages):
            name = extract_name_from_page(page, i)
            pages_with_names.append((name, i))

    # מיין לפי שם
    pages_with_names.sort(key=lambda x: x[0])

    reader = PyPDF2.PdfReader(input_path)
    writer = PyPDF2.PdfWriter()

    for name, page_num in pages_with_names:
        writer.add_page(reader.pages[page_num])

    with open(output_path, "wb") as f_out:
        writer.write(f_out)

    print(f"\nהקובץ החדש נוצר: {output_path}")


if __name__ == "__main__":
    print("Python path:", sys.executable)
    print("Python version:", sys.version)

    if len(sys.argv) != 3:
        print("שימוש: sort_pdf_by_name.py קובץ_מקור.pdf קובץ_יעד.pdf")
        sys.exit(1)

    input_pdf_path = sys.argv[1]
    output_pdf_path = sys.argv[2]

    try:
        sort_pdf_by_name(input_pdf_path, output_pdf_path)
        print("הקובץ מוין בהצלחה!")
        sys.exit(0)
    except Exception as e:
        print("שגיאה:", e)
        traceback.print_exc()
        sys.exit(1)

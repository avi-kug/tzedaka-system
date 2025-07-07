import sys
import pdfplumber
import PyPDF2
from bidi.algorithm import get_display
import sys
import io
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')


def extract_name_from_page(page, i):
    text = page.extract_text()
    if text and "לכבוד" in text:
        for line in text.split("\n"):
            if "לכבוד" in line:
                name = line.replace("לכבוד", "").strip()
                return get_display(name)  # הופך את הטקסט לכיוון תקין בעברית
    return "zzzz"  # כדי לשים עמודים בלי שם בסוף

def sort_pdf_by_name(input_path, output_path):
    with pdfplumber.open(input_path) as pdf:
        pages_with_names = []
        for i, page in enumerate(pdf.pages):
            name = extract_name_from_page(page, i)
            print(f"עמוד {i+1}: {name}")
            pages_with_names.append((name, i))

    pages_with_names.sort(key=lambda x: x[0])

    reader = PyPDF2.PdfReader(input_path)
    writer = PyPDF2.PdfWriter()
    for name, page_num in pages_with_names:
        writer.add_page(reader.pages[page_num])

    with open(output_path, "wb") as f_out:
        writer.write(f_out)

if __name__ == "__main__":
    print("Python path:", sys.executable)
    print("Python version:", sys.version)

    if len(sys.argv) != 3:
        print("שימוש: sort_pdf.py קובץ_מקור קובץ_יעד")
        sys.exit(1)

    input_pdf_path = sys.argv[1]
    output_pdf_path = sys.argv[2]

    try:
        sort_pdf_by_name(input_pdf_path, output_pdf_path)
        print("הקובץ מוין בהצלחה!")
        sys.exit(0)
    except Exception as e:
        print("שגיאה:", e)
        sys.exit(1)

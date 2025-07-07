import sys
import pdfplumber
import PyPDF2
import re

def extract_name(text):
    match = re.search(r'לכבוד\s+(.*)', text)
    if match:
        return match.group(1).strip()
    return "zzz"

def sort_pdf_by_name(input_pdf_path, output_pdf_path):
    with pdfplumber.open(input_pdf_path) as pdf:
        pages_with_names = []
        for i, page in enumerate(pdf.pages):
            text = page.extract_text()
            name = extract_name(text) if text else "zzz"
            pages_with_names.append((name, i))

    pages_with_names.sort(key=lambda x: x[0])

    reader = PyPDF2.PdfReader(input_pdf_path)
    writer = PyPDF2.PdfWriter()

    for name, page_index in pages_with_names:
        writer.add_page(reader.pages[page_index])

    with open(output_pdf_path, 'wb') as f:
        writer.write(f)

if __name__ == "__main__":
    input_pdf_path = sys.argv[1]
    output_pdf_path = sys.argv[2]
    sort_pdf_by_name(input_pdf_path, output_pdf_path)

import html2pdf from 'html2pdf.js';
import * as XLSX from 'xlsx';

const btnDownload = document.getElementById("btn-download");
const element = document.getElementById('evidence-table');
const exportExcelButton = document.getElementById('btn-download-excel');

btnDownload.addEventListener('click', function () {
    html2pdf().set({
        margin:       0.3,
        pagebreak: {mode: 'avoid-all'},
        jsPDF: {unit: 'in', format: 'a4', orientation: 'landscape'}
    }).from(element).save();
})

function htmlToExcel() {
    const htmlTable = document.querySelector('.table');
    const wb = XLSX.utils.table_to_book(htmlTable);
    XLSX.writeFile(wb, "BangMinhChung.xlsx");
}

exportExcelButton.addEventListener('click', htmlToExcel);

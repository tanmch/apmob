// PDF Export functionality
function exportFunc() {
    const canvasPromises = [];
    [humidCtx, tempCtx, pressCtx].forEach(ctx => {
        const element = ctx.canvas;
        const promise = html2canvas(element).then(function(canvas) {
            return canvas.toDataURL('image/png');
        });
        canvasPromises.push(promise);
    });

    Promise.all(canvasPromises).then(function(imgDataArray) {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({
            orientation: "portrait",
            format: "a4",
        });

        imgDataArray.forEach((imgData, index) => {
            const x = 10;
            const y = index * 110 + 10;
            pdf.addImage(imgData, 'PNG', x, y, 180, 90);
        });

        const pdfOutput = pdf.output('blob');
        const url = URL.createObjectURL(pdfOutput);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'chart.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    });
}

// Add event listener when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const exportButton = document.getElementById('export');
    if (exportButton) {
        exportButton.addEventListener('click', exportFunc);
    }
}); 
 function exportKeCSV() {
  const table = document.querySelector("table");
  const rows = table.querySelectorAll("tr");
  let csv = [];

  rows.forEach(row => {
    let cols = row.querySelectorAll("td, th");
    let rowData = [];
    cols.forEach(col => rowData.push('"' + col.innerText + '"'));
    csv.push(rowData.join(","));
  });

  // Buat file CSV dan unduh
  const csvContent = new Blob([csv.join("\n")], { type: "text/csv" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(csvContent);
  link.download = "tabel_data.csv";
  link.click();
  }
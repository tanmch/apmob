    // Realtime sensor data (last reading)
    const userId = "fC025qU0wYahubY0KEogSsRsBku1";
    const readingsRef = database.ref(`UsersData/${userId}/readings`);

    // Format timestamp ke waktu lokal
    function formatTime(ts) {
      const date = new Date(ts * 1000);
      return date.toLocaleString('id-ID', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
    }
    function convertToTimestamp(datetimeStr) {
      return Math.floor(new Date(datetimeStr).getTime() / 1000);
    }
    // Tampilkan semua data
    function displayAllData() {
      readingsRef.once("value", (snapshot) => {
        const data = snapshot.val();
        if (!data) {
          document.getElementById("history-table-body").innerHTML = "<tr><td colspan='5'>No data available</td></tr>";
          return;
        }
      
        const tableBody = document.getElementById("history-table-body");
        tableBody.innerHTML = "";
      
        // Sort data berdasarkan timestamp (terbaru di atas)
        const sortedData = Object.entries(data).sort((a, b) => b[1].timestamp - a[1].timestamp);
      
        sortedData.forEach(([key, value]) => {
          const row = `<tr>
            <td>${formatTime(value.timestamp)}</td>
            <td>${value.temperature}</td>
            <td>${value.humidity}</td>
            <td>${value.pressure}</td>
            <td>${value.servoStatus}</td>
          </tr>`;
          tableBody.innerHTML += row;
        });
      });
    }

    // Filter data historis
    function filterHistoricalData() {
      const start = document.getElementById("filter-start").value;
      const end = document.getElementById("filter-end").value;
      
      if (!start || !end) {
        alert("Silakan pilih tanggal mulai dan tanggal akhir");
        return;
      }
    
      const startTime = convertToTimestamp(start);
      const endTime = convertToTimestamp(end);
    
      readingsRef.once("value", (snapshot) => {
        const data = snapshot.val();
        if (!data) {
          document.getElementById("history-table-body").innerHTML = "<tr><td colspan='5'>Tidak ada data tersedia</td></tr>";
          return;
        }
      
        const tableBody = document.getElementById("history-table-body");
        tableBody.innerHTML = "";
      
        // Filter dan sort data
        const filteredData = Object.entries(data)
          .filter(([_, value]) => value.timestamp >= startTime && value.timestamp <= endTime)
          .sort((a, b) => b[1].timestamp - a[1].timestamp);
      
        if (filteredData.length === 0) {
          tableBody.innerHTML = "<tr><td colspan='5'>Tidak ada data untuk rentang waktu yang dipilih</td></tr>";
          return;
        }
      
        filteredData.forEach(([key, value]) => {
          const row = `<tr>
            <td>${formatTime(value.timestamp)}</td>
            <td>${value.temperature}</td>
            <td>${value.humidity}</td>
            <td>${value.pressure}</td>
            <td>${value.servoStatus}</td>
          </tr>`;
          tableBody.innerHTML += row;
        });
      });
    }

    // Hapus semua data
    function clearAllHistory() {
      if (confirm("Yakin ingin menghapus semua riwayat?")) {
        readingsRef.remove()
          .then(() => {
            alert("Semua data berhasil dihapus.");
            document.getElementById("history-table-body").innerHTML = "<tr><td colspan='5'>Tidak ada data tersedia</td></tr>";
          })
          .catch(error => {
            console.error("Error deleting data:", error);
            alert("Gagal menghapus data. Silakan coba lagi.");
          });
      }
    }
    
    // Hapus data dalam rentang waktu
    function deleteDataRange() {
      const start = document.getElementById("delete-start").value;
      const end = document.getElementById("delete-end").value;
      
      if (!start || !end) {
        alert("Silakan pilih tanggal mulai dan tanggal akhir");
        return;
      }
    
      if (!confirm("Yakin ingin menghapus data dalam rentang waktu ini?")) {
        return;
      }
    
      const startTime = convertToTimestamp(start);
      const endTime = convertToTimestamp(end);
    
      readingsRef.once("value", (snapshot) => {
        const data = snapshot.val();
        if (!data) {
          alert("Tidak ada data yang tersedia untuk dihapus");
          return;
        }
      
        const deletePromises = [];
        Object.entries(data).forEach(([key, value]) => {
          if (value.timestamp >= startTime && value.timestamp <= endTime) {
            deletePromises.push(readingsRef.child(key).remove());
          }
        });
      
        Promise.all(deletePromises)
          .then(() => {
            alert("Data dalam rentang waktu telah dihapus.");
            document.getElementById("history-table-body").innerHTML = "<tr><td colspan='5'>Silakan filter data untuk melihat hasil</td></tr>";
          })
          .catch(error => {
            console.error("Error deleting data:", error);
            alert("Gagal menghapus data. Silakan coba lagi.");
          });
      });
    }

    // Initialize table when page loads
    document.addEventListener('DOMContentLoaded', () => {
      // Tampilkan pesan awal
      document.getElementById("history-table-body").innerHTML = "<tr><td colspan='5'>Silakan filter data untuk melihat riwayat</td></tr>";
      
      // Set default date range (24 jam terakhir)
      const now = new Date();
      const yesterday = new Date(now.getTime() - 24 * 60 * 60 * 1000);
      
      document.getElementById("filter-start").value = yesterday.toISOString().slice(0, 16);
      document.getElementById("filter-end").value = now.toISOString().slice(0, 16);
    });

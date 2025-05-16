// Chart configuration and sensor data handling
const userId = "fC025qU0wYahubY0KEogSsRsBku1"; // Keep the same userId
const readingsRef = database.ref(`UsersData/${userId}/readings`);

function updateText(id, value) {
    document.getElementById(id).textContent = value;
}

function updateGauge(id, percent) {
    document.getElementById(id).style.width = percent + '%';
}

function formatTime(ts) {
    const date = new Date(ts * 1000);
    return date.toLocaleTimeString();
}

// Initialize charts
const tempCtx = document.getElementById("temperature-chart").getContext("2d");
const humidCtx = document.getElementById("humidity-chart").getContext("2d");
const pressCtx = document.getElementById("pressure-chart").getContext("2d");

let temperatureChart, humidityChart, pressureChart;

// Listen for real-time updates
readingsRef.limitToLast(1).on("value", (snapshot) => {
    const data = snapshot.val();
    if (!data) return;
    const last = Object.values(data)[0];

    const temp = parseFloat(last.temperature);
    const humid = parseFloat(last.humidity);
    const press = parseFloat(last.pressure);

    // Update UI
    updateText("temperature-value", temp + " °C");
    updateGauge("temperature-gauge", Math.min(temp, 100));
    updateText("humidity-value", humid + " %");
    updateGauge("humidity-gauge", Math.min(humid, 100));
    updateText("pressure-value", press + " hPa");
    updateGauge("pressure-gauge", Math.min(press / 10, 100));
    updateText("servo-status", last.servoStatus);
    document.getElementById("servo-icon").className =
        "servo-icon fas " + (last.servoStatus === "Open" ? "fa-door-open" : "fa-door-closed");

    // Send notification for new sensor data
    if (Notification.permission === 'granted') {
        let notificationTitle, notificationBody;
        
        if (last.servoStatus === "Open") {
            notificationTitle = "🌤️ Clothes Drying Mode";
            notificationBody = `Clothes are being dried in good weather conditions.`;
        } else {
            notificationTitle = "🌧️ Clothes Protected";
            notificationBody = `Clothes are protected from adverse weather conditions.`;
        }

        // Show notification
        new Notification(notificationTitle, {
            body: notificationBody,
            icon: '/pun-god.jpg'
        });

        // Send to Firebase Cloud Messaging
        fetch('/send-notification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                title: notificationTitle,
                body: notificationBody
            })
        }).catch(error => console.error('Error sending FCM notification:', error));
    }
});

// Update charts with historical data
readingsRef.limitToLast(20).on("value", (snapshot) => {
    const data = snapshot.val();
    if (!data) return;

    const labels = [], tempData = [], humidData = [], pressData = [];

    Object.values(data).forEach(entry => {
        labels.push(formatTime(entry.timestamp));
        tempData.push(parseFloat(entry.temperature));
        humidData.push(parseFloat(entry.humidity));
        pressData.push(parseFloat(entry.pressure));
    });

    const configChart = (ctx, label, data, bgColor, borderColor) => ({
        type: "line",
        data: {
            labels,
            datasets: [{
                label,
                data,
                backgroundColor: bgColor,
                borderColor,
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: false }
            }
        }
    });

    if (!temperatureChart) {
        temperatureChart = new Chart(tempCtx, configChart(tempCtx, "Temperature (°C)", tempData, "rgba(243, 156, 18, 0.2)", "#f39c12"));
    } else {
        temperatureChart.data.labels = labels;
        temperatureChart.data.datasets[0].data = tempData;
        temperatureChart.update();
    }

    if (!humidityChart) {
        humidityChart = new Chart(humidCtx, configChart(humidCtx, "Humidity (%)", humidData, "rgba(52, 152, 219, 0.2)", "#3498db"));
    } else {
        humidityChart.data.labels = labels;
        humidityChart.data.datasets[0].data = humidData;
        humidityChart.update();
    }

    if (!pressureChart) {
        pressureChart = new Chart(pressCtx, configChart(pressCtx, "Pressure (hPa)", pressData, "rgba(46, 204, 113, 0.2)", "#2ecc71"));
    } else {
        pressureChart.data.labels = labels;
        pressureChart.data.datasets[0].data = pressData;
        pressureChart.update();
    }
}); 
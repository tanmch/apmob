// Notification handling
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then(registration => {
            console.log("Service Worker registered successfully");
            messaging.useServiceWorker(registration);
        })
        .catch(error => {
            console.error("Service Worker registration failed:", error);
        });
}

function sendTokenToServer(token) {
    fetch('/notification-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ token: token })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Token saved successfully:', data);
    })
    .catch(error => {
        console.error('Error saving token:', error);
    });
}

function getToken() {
    messaging.getToken({ 
        vapidKey: window.FIREBASE_VAPID_KEY
    })
    .then((currentToken) => {
        if (currentToken) {
            console.log('Device token:', currentToken);
            sendTokenToServer(currentToken);
        } else {
            console.log('No registration token available.');
        }
    })
    .catch((err) => {
        console.error('Error getting token:', err);
    });
}

// Handle foreground messages
messaging.onMessage((payload) => {
    console.log('Received foreground message:', payload);
    
    if (Notification.permission === 'granted') {
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: '/icon.png'
        };
        
        new Notification(notificationTitle, notificationOptions);
    }
});

// Initialize notification permission
document.addEventListener('DOMContentLoaded', () => {
    const notificationButton = document.getElementById('notification-permission');
    if (!notificationButton) return;

    if (Notification.permission === 'granted') {
        console.log('Notifications already enabled');
        getToken();
        notificationButton.textContent = 'Notifications Enabled';
        notificationButton.disabled = true;
    } else if (Notification.permission === 'denied') {
        console.log('Notifications denied');
        notificationButton.textContent = 'Notifications Blocked';
        notificationButton.disabled = true;
    }

    notificationButton.addEventListener('click', () => {
        if (Notification.permission === 'granted') {
            console.log('Notifications already enabled');
            getToken();
        } else if (Notification.permission === 'denied') {
            console.log('Notifications denied. Please enable in browser settings.');
        } else {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Notifications enabled');
                    getToken();
                    notificationButton.textContent = 'Notifications Enabled';
                    notificationButton.disabled = true;
                } else {
                    console.log('Notifications denied');
                    notificationButton.textContent = 'Enable Notifications';
                }
            });
        }
    });
}); 
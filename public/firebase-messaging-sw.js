/* Firebase Messaging Something" */ 
importScripts("https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js");

firebase.initializeApp({
  apiKey:FIREBASE_API_KEY,
  authDomain: FIREBASE_AUTH_DOMAIN, 
  databaseURL: FIREBASE_DATABASE_URL,
  projectId: FIREBASE_PROJECT_ID, 
  storageBucket: FIREBASE_STORAGE_BUCKET, 
  messagingSenderId: FIREBASE_MESSAGING_SENDER_ID,
  appId: FIREBASE_APP_ID, 
});

const messaging = firebase.messaging();

messaging.onMessage((payload) => {
    console.log('Menerima pesan foreground:', payload);
    // TODO : Graphical Notification
  }); 

// Handle background messages
messaging.onBackgroundMessage((payload) => {
  console.log('Received background message:', payload);

  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png' // Make sure to add an icon file in your public directory
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
  

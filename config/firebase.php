<?php

return [
    'database_url' => env('FIREBASE_DATABASE_URL', 'https://pemweb-f3303-default-rtdb.asia-southeast1.firebasedatabase.app'),
    'project_id' => env('FIREBASE_PROJECT_ID', 'pemweb-f3303'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'pemweb-f3303.appspot.com'),
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID', '484952716978'),
    'app_id' => env('FIREBASE_APP_ID', '1:484952716978:web:fe6a337f421b6264043bab'),
    'api_key' => env('FIREBASE_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN', 'pemweb-f3303.firebaseapp.com'),
    'vapid_key' => env('FIREBASE_VAPID_KEY'),
]; 
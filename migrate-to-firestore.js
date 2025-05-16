import { initializeApp, cert, getApps, deleteApp } from 'firebase-admin/app';
import { getFirestore } from 'firebase-admin/firestore';
import { getDatabase } from 'firebase-admin/database';
import { readFileSync } from 'fs';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

// Get the directory name
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Initialize Firebase Admin with your service account
const serviceAccount = JSON.parse(readFileSync(join(__dirname, 'storage/app/firebase/firebase_credentials.json'), 'utf8'));

const app = initializeApp({
  credential: cert(serviceAccount),
  databaseURL: "https://pemweb-f3303-default-rtdb.asia-southeast1.firebasedatabase.app"
});

const db = getFirestore();
const rtdb = getDatabase();

async function migrateData() {
  try {
    // Read the JSON file
    const data = JSON.parse(readFileSync(join(__dirname, 'pemweb-f3303-default-rtdb-export.json'), 'utf8'));
    
    // Migrate UsersData
    if (data.UsersData) {
      for (const [userId, userData] of Object.entries(data.UsersData)) {
        // Migrate readings
        if (userData.readings) {
          const readingsRef = db.collection('UsersData').doc(userId).collection('readings');
          for (const [timestamp, reading] of Object.entries(userData.readings)) {
            await readingsRef.doc(timestamp).set(reading);
            console.log(`Migrated reading ${timestamp} for user ${userId}`);
          }
        }
      }
    }

    // Migrate Posts
    if (data.posts) {
      const postsRef = db.collection('posts');
      for (const [postId, post] of Object.entries(data.posts)) {
        await postsRef.doc(postId).set(post);
        console.log(`Migrated post ${postId}`);
      }
    }

    // Migrate Users
    if (data.users) {
      const usersRef = db.collection('users');
      for (const [userId, user] of Object.entries(data.users)) {
        await usersRef.doc(userId).set(user);
        console.log(`Migrated user ${userId}`);
      }
    }

    console.log('Migration completed successfully!');
  } catch (error) {
    console.error('Error during migration:', error);
  } finally {
    // Close the connection
    deleteApp(app);
  }
}

// Run the migration
migrateData(); 
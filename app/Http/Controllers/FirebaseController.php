<?php

namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
 
class FirebaseController extends Controller 
{ 
    public function create() 
    { 
        $database = app('firebase.database'); 
        $reference = $database->getReference('users'); 
 
        // Simpan data ke Firebase 
        $newUser = $reference->push([ 
            'name' => 'John Doe', 
            'email' => 'john@example.com', 
            'created_at' => now()->toDateTimeString(), 
        ]); 
 
        return response()->json([ 
            'message' => 'User berhasil ditambahkan', 
            'firebase_key' => $newUser->getKey(), 
        ]); 
    } 
} 
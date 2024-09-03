<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Credentials
    |--------------------------------------------------------------------------
    |
    | The path to the Firebase Service Account key JSON file. Ensure that the 
    | path points to the correct file within your project.
    |
    */

    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS', storage_path('firebase/service-account-key.json')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Realtime Database
    |--------------------------------------------------------------------------
    |
    | The URL to the Firebase Realtime Database instance. This should match 
    | the URL from the Firebase project settings.
    |
    */

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL', 'https://bcv1-d6838-default-rtdb.asia-southeast1.firebasedatabase.app'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Storage
    |--------------------------------------------------------------------------
    |
    | The Firebase Storage Bucket name, without `gs://` or any prefix.
    |
    */

    'storage' => [
        'bucket' => env('FIREBASE_STORAGE_BUCKET', 'bcv1-d6838.appspot.com'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Auth
    |--------------------------------------------------------------------------
    |
    | The Firebase Authentication settings, such as the API Key.
    |
    */

    'auth' => [
        'api_key' => env('FIREBASE_API_KEY', 'AIzaSyDGeCHzLu7OGQlCgyntd8ag5yQYxBVXdyA'),
    ],

];

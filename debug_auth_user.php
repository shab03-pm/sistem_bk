<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

// Get authenticated user
$user = auth()->user();

if ($user) {
    echo "=== AUTH USER DEBUG ===\n";
    echo "User ID: " . $user->id . "\n";
    echo "User Class: " . get_class($user) . "\n";
    echo "User Email: " . ($user->email ?? 'N/A') . "\n";
    echo "User Name: " . ($user->name ?? 'N/A') . "\n";
    echo "User Nama: " . ($user->nama ?? 'N/A') . "\n";
    echo "User NIS: " . ($user->nis ?? 'N/A') . "\n";
    echo "Has Role Method: " . (method_exists($user, 'role') ? 'Yes' : 'No') . "\n";
    echo "Has Role Attribute: " . (isset($user->role) ? 'Yes' : 'No') . "\n";
    echo "User Role: " . ($user->role ?? 'N/A') . "\n";
    echo "User Attributes: " . json_encode($user->getAttributes()) . "\n";
} else {
    echo "No user authenticated\n";
}

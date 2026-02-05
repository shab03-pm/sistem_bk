<?php
// Test register with file using simulated form submission

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create temporary test file
$testFileContent = file_get_contents('phpunit.xml');
$tempFile = tempnam(sys_get_temp_dir(), 'test_raport_');
rename($tempFile, $tempFile . '.jpg');
$tempFile = $tempFile . '.jpg';
file_put_contents($tempFile, $testFileContent);

// Simulate HTTP request with file
$app['request']->initialize(
    [],
    [
        'name' => 'Test User',
        'nis' => '123456',
        'kelas_asal' => 'X MERDEKA 1',
        'email' => 'test' . time() . '@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'nilai_matematika' => 85,
        'nilai_fisika' => 80,
        'nilai_kimia' => 90,
        'nilai_biologi' => 88,
        'nilai_tik' => 92,
        'nilai_binggris' => 85,
        'nilai_sosiologi' => 87,
        'nilai_ekonomi' => 86,
        'nilai_geografi' => 84,
    ],
    [],
    [],
    ['file_raport' => new \Symfony\Component\HttpFoundation\File\UploadedFile($tempFile, 'test_raport.jpg', 'image/jpeg', null, true)]
);

// Try to register
try {
    $controller = $app->make(\App\Http\Controllers\Auth\RegisteredUserController::class);
    $result = $controller->store($app['request']);
    echo "Registration successful!\n";
    
    // Check if file was saved
    $siswa = \App\Models\Siswa::latest()->first();
    echo "Siswa: " . $siswa->nama . "\n";
    echo "File stored: " . ($siswa->file_raport ?? 'NULL') . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Cleanup
unlink($tempFile);

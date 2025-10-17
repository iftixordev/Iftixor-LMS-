<?php
echo "=== Tizim Tekshiruvi ===\n\n";

// 1. PHP versiyasi
echo "PHP: " . PHP_VERSION . "\n";

// 2. Kerakli kengaytmalar
$extensions = ['pdo', 'pdo_sqlite', 'mbstring', 'openssl', 'json'];
foreach($extensions as $ext) {
    echo "Extension $ext: " . (extension_loaded($ext) ? '✓' : '✗') . "\n";
}

// 3. Papka ruxsatlari
$dirs = ['storage', 'bootstrap/cache', 'public_html'];
foreach($dirs as $dir) {
    $writable = is_writable($dir);
    echo "Writable $dir: " . ($writable ? '✓' : '✗') . "\n";
}

// 4. Fayllar mavjudligi
$files = [
    'public_html/index.php',
    'public_html/css/gemini-admin.css',
    'public_html/js/error-handler.js',
    'database/database.sqlite'
];
foreach($files as $file) {
    echo "File $file: " . (file_exists($file) ? '✓' : '✗') . "\n";
}

// 5. Database ulanish
try {
    require 'vendor/autoload.php';
    $app = require 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    DB::connection()->getPdo();
    echo "Database: ✓\n";
} catch(Exception $e) {
    echo "Database: ✗ " . $e->getMessage() . "\n";
}

echo "\n=== Tekshiruv tugadi ===\n";
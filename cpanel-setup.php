<?php
/**
 * cPanel Setup Script
 * Run this file once after uploading to cPanel
 */

echo "cPanel Laravel Setup Starting...\n";

// 1. Create necessary directories
$dirs = [
    'storage/logs',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    }
}

// 2. Set permissions
chmod('storage', 0755);
chmod('bootstrap/cache', 0755);
echo "Permissions set\n";

// 3. Create storage link
if (!file_exists('public_html/storage')) {
    symlink('../storage/app/public', 'public_html/storage');
    echo "Storage link created\n";
}

// 4. Clear caches
if (file_exists('bootstrap/cache/config.php')) {
    unlink('bootstrap/cache/config.php');
}
if (file_exists('bootstrap/cache/routes.php')) {
    unlink('bootstrap/cache/routes.php');
}
echo "Caches cleared\n";

// 5. Test database connection
try {
    require 'vendor/autoload.php';
    $app = require 'bootstrap/app.php';
    
    $dbPath = $app['App\Helpers\DatabaseHelper']::findSqliteDatabase();
    echo "Database path: $dbPath\n";
    
    if (file_exists($dbPath)) {
        echo "Database found ✓\n";
    } else {
        echo "Database not found - will be created on first run\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "cPanel setup completed!\n";
echo "Your site should now work at your domain.\n";
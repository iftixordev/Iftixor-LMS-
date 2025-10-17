<?php
/**
 * Avtomatik konfiguratsiya - .env faylsiz ishlash
 * Bu faylni CPanel ga yuklashdan keyin ishga tushiring
 */

echo "Avtomatik konfiguratsiya boshlandi...\n";

// 1. Kerakli papkalarni yaratish
$dirs = [
    'storage/logs',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/app/public',
    'bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Papka yaratildi: $dir\n";
    }
}

// 2. Ruxsatlarni sozlash
chmod('storage', 0755);
chmod('bootstrap/cache', 0755);
if (is_dir('storage/logs')) {
    chmod('storage/logs', 0755);
}

// 3. Storage linkini yaratish
$storageLink = 'public_html/storage';
if (!file_exists($storageLink) && is_dir('storage/app/public')) {
    if (is_link($storageLink)) {
        unlink($storageLink);
    }
    symlink('../storage/app/public', $storageLink);
    echo "Storage linki yaratildi\n";
}

// 4. Cache fayllarini tozalash
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/packages.php',
    'bootstrap/cache/services.php'
];

foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Cache tozalandi: $file\n";
    }
}

// 5. Database yo'lini tekshirish
try {
    require_once 'vendor/autoload.php';
    require_once 'app/Helpers/DatabaseHelper.php';
    
    $dbPath = App\Helpers\DatabaseHelper::findSqliteDatabase();
    echo "Database yo'li: $dbPath\n";
    
    if (!file_exists($dbPath)) {
        $dbDir = dirname($dbPath);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }
        touch($dbPath);
        chmod($dbPath, 0644);
        echo "Database fayli yaratildi\n";
    } else {
        echo "Database mavjud ✓\n";
    }
} catch (Exception $e) {
    echo "Xatolik: " . $e->getMessage() . "\n";
}

// 6. .htaccess faylini tekshirish
$htaccess = 'public_html/.htaccess';
if (!file_exists($htaccess)) {
    $htaccessContent = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>';
    
    file_put_contents($htaccess, $htaccessContent);
    echo ".htaccess fayli yaratildi\n";
}

echo "\nKonfiguratsiya tugallandi! ✓\n";
echo "Saytingiz tayyor: " . (isset($_SERVER['HTTP_HOST']) ? 'https://' . $_SERVER['HTTP_HOST'] : 'sizning domeningiz') . "\n";
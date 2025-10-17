<?php

// Avtomatik setup skripti
echo "Laravel loyihani sozlash boshlandi...\n";

// 1. Composer install
if (!file_exists('vendor/autoload.php')) {
    echo "Composer paketlarni o'rnatish...\n";
    exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $return);
    if ($return !== 0) {
        echo "Composer xatosi. Manual: composer install\n";
    }
}

// 2. Storage linkini yaratish
if (!file_exists('public/storage')) {
    echo "Storage linkini yaratish...\n";
    exec('php artisan storage:link 2>&1');
}

// 3. Cache tozalash va yaratish
echo "Cache sozlash...\n";
exec('php artisan config:cache 2>&1');
exec('php artisan route:cache 2>&1');
exec('php artisan view:cache 2>&1');

// 4. Database migratsiya
echo "Database sozlash...\n";
exec('php artisan migrate --force 2>&1');

// 5. Ruxsatlarni sozlash
echo "Ruxsatlarni sozlash...\n";
exec('chmod -R 755 storage bootstrap/cache 2>&1');
exec('chmod -R 777 storage/logs storage/framework 2>&1');

echo "Setup tugadi! Sayt tayyor.\n";
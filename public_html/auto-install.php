<?php
// Avtomatik o'rnatish - birinchi sahifa ochilganda
if (!file_exists('../storage/app/setup_done')) {
    echo "<!DOCTYPE html><html><head><title>O'rnatish...</title></head><body>";
    echo "<h2>Loyiha o'rnatilmoqda...</h2>";
    echo "<p>Iltimos kuting...</p>";
    
    // Composer
    if (!file_exists('../vendor/autoload.php')) {
        echo "<p>Composer paketlar o'rnatilmoqda...</p>";
        exec('cd .. && composer install --no-dev --optimize-autoloader 2>&1');
    }
    
    // Laravel setup
    echo "<p>Laravel sozlanmoqda...</p>";
    exec('cd .. && php artisan storage:link 2>&1');
    exec('cd .. && php artisan config:cache 2>&1');
    exec('cd .. && php artisan migrate --force 2>&1');
    
    // Ruxsatlar
    @chmod('../storage', 0755);
    @chmod('../storage/logs', 0777);
    @chmod('../bootstrap/cache', 0755);
    
    // Tugadi
    @mkdir('../storage/app', 0755, true);
    file_put_contents('../storage/app/setup_done', date('Y-m-d H:i:s'));
    
    echo "<p><strong>Tayyor!</strong></p>";
    echo "<script>setTimeout(() => location.reload(), 2000);</script>";
    echo "</body></html>";
    exit;
}

// Asosiy sahifaga yo'naltirish
header('Location: index.php');
exit;
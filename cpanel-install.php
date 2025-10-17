<?php
// cPanel uchun avtomatik o'rnatish skripti

// 1. .env fayl yaratish
$envContent = 'APP_NAME="O\'quv Markazi SCM"
APP_ENV=production
APP_KEY=base64:ZADn547Ry0P5Rqrgb4YJHqGhcwX068ea/4IZqPas9lM=
APP_DEBUG=false
APP_URL=' . (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=' . __DIR__ . '/database/database.sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"';

file_put_contents(__DIR__ . '/.env', $envContent);

// 2. Storage papkalarini yaratish va ruxsat berish
$storageDirs = [
    'storage/app/public',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($storageDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
    }
    chmod($fullPath, 0755);
}

// 3. SQLite fayli mavjudligini tekshirish
$sqliteFile = __DIR__ . '/database/database.sqlite';
if (!file_exists($sqliteFile)) {
    touch($sqliteFile);
    chmod($sqliteFile, 0644);
}

// 4. Symbolic link yaratish
$publicPath = __DIR__ . '/public_html';
$storageLinkPath = $publicPath . '/storage';
if (!file_exists($storageLinkPath)) {
    symlink(__DIR__ . '/storage/app/public', $storageLinkPath);
}

echo "cPanel o'rnatish muvaffaqiyatli yakunlandi!\n";
echo "Sayt: " . (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . "\n";
?>
<?php

/**
 * .env faylsiz ishlash uchun muhit o'zgaruvchilarini sozlash
 */

use App\Helpers\DatabaseHelper;

// Asosiy muhit o'zgaruvchilari
$_ENV['APP_NAME'] = DatabaseHelper::getAppName();
$_ENV['APP_ENV'] = DatabaseHelper::isProduction() ? 'production' : 'local';
$_ENV['APP_DEBUG'] = DatabaseHelper::isProduction() ? 'false' : 'true';
$_ENV['APP_KEY'] = DatabaseHelper::getAppKey();
$_ENV['APP_URL'] = DatabaseHelper::getAppUrl();

// Database sozlamalari
$_ENV['DB_CONNECTION'] = 'sqlite';
// DB_DATABASE keyinroq o'rnatiladi

// Cache va session sozlamalari
$_ENV['CACHE_DRIVER'] = 'file';
$_ENV['SESSION_DRIVER'] = 'file';
$_ENV['SESSION_LIFETIME'] = '120';
$_ENV['QUEUE_CONNECTION'] = 'sync';

// Log sozlamalari
$_ENV['LOG_CHANNEL'] = 'stack';
$_ENV['LOG_LEVEL'] = 'debug';

// Mail sozlamalari (default)
$_ENV['MAIL_MAILER'] = 'smtp';
$_ENV['MAIL_HOST'] = 'localhost';
$_ENV['MAIL_PORT'] = '587';
$_ENV['MAIL_FROM_ADDRESS'] = 'noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$_ENV['MAIL_FROM_NAME'] = $_ENV['APP_NAME'];
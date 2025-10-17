<?php

namespace App\Helpers;

class ConfigHelper
{
    public static function getEnv($key, $default = null)
    {
        // .env fayldan o'qishga harakat qilish
        $envValue = $_ENV[$key] ?? getenv($key);
        if ($envValue !== false && $envValue !== null) {
            return $envValue;
        }
        
        // .env fayl mavjud bo'lsa o'qish
        $envFile = base_path('.env');
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            if (preg_match("/^{$key}=(.*)$/m", $envContent, $matches)) {
                return trim($matches[1], '"\'');
            }
        }
        
        // Default qiymatlar
        return self::getDefaultConfig($key, $default);
    }
    
    private static function getDefaultConfig($key, $fallback = null)
    {
        $defaults = [
            'APP_NAME' => "O'quv Markazi SCM",
            'APP_ENV' => self::isProduction() ? 'production' : 'local',
            'APP_DEBUG' => !self::isProduction(),
            'APP_KEY' => 'base64:ZADn547Ry0P5Rqrgb4YJHqGhcwX068ea/4IZqPas9lM=',
            'APP_URL' => self::getAppUrl(),
            'DB_CONNECTION' => 'sqlite',
            'LOG_CHANNEL' => 'stack',
            'CACHE_DRIVER' => 'file',
            'SESSION_DRIVER' => 'file',
            'SESSION_LIFETIME' => 120,
            'QUEUE_CONNECTION' => 'sync',
        ];
        
        return $defaults[$key] ?? $fallback;
    }
    
    private static function isProduction()
    {
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return !in_array($host, ['localhost', '127.0.0.1', '::1']);
    }
    
    private static function getAppUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                       (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
            return $protocol . '://' . $_SERVER['HTTP_HOST'];
        }
        return 'http://localhost';
    }
}
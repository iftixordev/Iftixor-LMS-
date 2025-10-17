<?php

namespace App\Helpers;

class DatabaseHelper
{
    public static function checkRequirements()
    {
        if (!function_exists('mb_split')) {
            function mb_split($pattern, $string, $limit = -1) {
                return preg_split('/' . preg_quote($pattern, '/') . '/', $string, $limit);
            }
        }
    }
    public static function findSqliteDatabase()
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? getcwd();
        $basePath = dirname($documentRoot);
        
        // CPanel uchun yo'llar
        $cPanelPaths = [
            $basePath . '/database/database.sqlite',
            $basePath . '/database/branch_asosiy_filial.sqlite',
            $basePath . '/private/database.sqlite',
            $basePath . '/db/database.sqlite'
        ];
        
        // Lokal development uchun yo'llar
        $localPaths = [
            __DIR__ . '/../../database/database.sqlite',
            getcwd() . '/database/database.sqlite'
        ];
        
        // Laravel helper funksiyalari mavjud bo'lsa
        try {
            if (function_exists('database_path') && app()->bound('path.database')) {
                array_unshift($localPaths, database_path('database.sqlite'));
            }
        } catch (Exception $e) {}
        
        try {
            if (function_exists('base_path') && app()->bound('path.base')) {
                array_unshift($localPaths, base_path('database/database.sqlite'));
            }
        } catch (Exception $e) {}
        
        $allPaths = array_merge($cPanelPaths, $localPaths);
        
        foreach ($allPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        // Default yo'l yaratish
        $defaultPath = __DIR__ . '/../../database/database.sqlite';
        try {
            if (function_exists('database_path') && app()->bound('path.database')) {
                $defaultPath = database_path('database.sqlite');
            }
        } catch (Exception $e) {}
            
        $dir = dirname($defaultPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        return $defaultPath;
    }

    public static function getAppUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                       (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
            return $protocol . '://' . $_SERVER['HTTP_HOST'];
        }
        return 'http://localhost';
    }

    public static function getAppKey()
    {
        return 'base64:ZADn547Ry0P5Rqrgb4YJHqGhcwX068ea/4IZqPas9lM=';
    }

    public static function getAppName()
    {
        return "O'quv Markazi SCM";
    }
    
    public static function isProduction()
    {
        return !in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', '::1']);
    }
}
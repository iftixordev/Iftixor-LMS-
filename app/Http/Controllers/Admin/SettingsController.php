<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'app_name' => 'required|string|max:255',
                'timezone' => 'required|string',
                'currency' => 'required|string|max:10',
                'language' => 'required|string|max:10',
                'date_format' => 'required|string|max:20',
                'time_format' => 'required|string|max:20',
                'number_format' => 'nullable|string|max:20',
                'per_page' => 'nullable|integer|min:10|max:100',
                'notifications' => 'nullable|array',
                'security' => 'nullable|array'
            ]);

            $this->saveSettings($validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sozlamalar muvaffaqiyatli saqlandi'
                ]);
            }

            return redirect()->route('admin.settings.index')
                ->with('success', 'Sozlamalar muvaffaqiyatli saqlandi');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Xatolik: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Xatolik: ' . $e->getMessage()]);
        }
    }

    private function getSettings()
    {
        $settings = Cache::get('app_settings');
        
        if (!$settings) {
            $settings = [
                'app_name' => config('app.name', 'Markaz CPanel'),
                'timezone' => config('app.timezone', 'Asia/Tashkent'),
                'currency' => 'UZS',
                'language' => 'uz',
                'date_format' => 'd.m.Y',
                'time_format' => 'H:i',
                'number_format' => 'space',
                'per_page' => '25',
                'notifications' => [
                    'email' => true,
                    'sms' => false
                ],
                'security' => [
                    'two_factor' => false,
                    'session_timeout' => true
                ]
            ];

            if (Storage::exists('settings.json')) {
                $fileSettings = json_decode(Storage::get('settings.json'), true);
                if ($fileSettings) {
                    $settings = array_merge($settings, $fileSettings);
                }
            }

            Cache::put('app_settings', $settings, 3600);
        }

        return $settings;
    }

    private function saveSettings($settings)
    {
        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
        Cache::put('app_settings', $settings, 3600);
        
        $envUpdates = [
            'APP_NAME' => $settings['app_name'],
            'APP_TIMEZONE' => $settings['timezone']
        ];
        
        foreach ($envUpdates as $key => $value) {
            $this->updateEnvFile($key, $value);
        }
    }

    private function updateEnvFile($key, $value)
    {
        $envFile = base_path('.env');
        
        if (!file_exists($envFile)) {
            return;
        }
        
        $str = file_get_contents($envFile);
        
        if ($key === 'APP_NAME') {
            $value = '"' . $value . '"';
        }
        
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}={$value}";
        
        if (preg_match($pattern, $str)) {
            $str = preg_replace($pattern, $replacement, $str);
        } else {
            $str .= "\n{$replacement}";
        }
        
        file_put_contents($envFile, $str);
    }
}
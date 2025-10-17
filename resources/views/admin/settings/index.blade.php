@extends('layouts.admin')

@section('content')
<div class="gemini-settings-container">
    <div class="gemini-settings-header">
        <div>
            <h1 class="gemini-page-title">Tizim Sozlamalari</h1>
            <p class="gemini-page-subtitle">Markaz boshqaruv paneli sozlamalarini o'zgartiring</p>
        </div>
        <div class="gemini-settings-actions">
            <button type="button" class="gemini-btn gemini-btn-secondary" onclick="resetSettings()">
                <i class="fas fa-undo"></i> Qayta tiklash
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="gemini-alert gemini-alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf
        @method('PUT')
        
        <div class="gemini-settings-grid">
            <!-- Asosiy sozlamalar -->
            <div class="gemini-settings-section">
                <div class="gemini-section-header">
                    <i class="fas fa-cog"></i>
                    <h3>Asosiy sozlamalar</h3>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-tag"></i>
                        Dastur nomi
                    </label>
                    <input type="text" name="app_name" class="gemini-input" value="{{ $settings['app_name'] }}" required>
                    <small class="gemini-help-text">Tizimda ko'rsatiladigan asosiy nom</small>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-globe"></i>
                        Vaqt zonasi
                    </label>
                    <select name="timezone" class="gemini-select" required>
                        <option value="Asia/Tashkent" {{ $settings['timezone'] == 'Asia/Tashkent' ? 'selected' : '' }}>Asia/Tashkent (UTC+5)</option>
                        <option value="Asia/Samarkand" {{ $settings['timezone'] == 'Asia/Samarkand' ? 'selected' : '' }}>Asia/Samarkand (UTC+5)</option>
                        <option value="UTC" {{ $settings['timezone'] == 'UTC' ? 'selected' : '' }}>UTC (GMT+0)</option>
                    </select>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-money-bill"></i>
                        Valyuta
                    </label>
                    <select name="currency" class="gemini-select" required>
                        <option value="UZS" {{ $settings['currency'] == 'UZS' ? 'selected' : '' }}>🇺🇿 O'zbek so'm (UZS)</option>
                        <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>🇺🇸 Dollar (USD)</option>
                        <option value="EUR" {{ $settings['currency'] == 'EUR' ? 'selected' : '' }}>🇪🇺 Evro (EUR)</option>
                        <option value="RUB" {{ $settings['currency'] == 'RUB' ? 'selected' : '' }}>🇷🇺 Rubl (RUB)</option>
                    </select>
                </div>

                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-language"></i>
                        Til
                    </label>
                    <select name="language" class="gemini-select" required>
                        <option value="uz" {{ $settings['language'] == 'uz' ? 'selected' : '' }}>🇺🇿 O'zbek tili</option>
                        <option value="ru" {{ $settings['language'] == 'ru' ? 'selected' : '' }}>🇷🇺 Rus tili</option>
                        <option value="en" {{ $settings['language'] == 'en' ? 'selected' : '' }}>🇺🇸 Ingliz tili</option>
                    </select>
                </div>
            </div>

            <!-- Format sozlamalari -->
            <div class="gemini-settings-section">
                <div class="gemini-section-header">
                    <i class="fas fa-calendar"></i>
                    <h3>Format sozlamalari</h3>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-calendar-day"></i>
                        Sana formati
                    </label>
                    <select name="date_format" class="gemini-select" required>
                        <option value="d.m.Y" {{ $settings['date_format'] == 'd.m.Y' ? 'selected' : '' }}>31.12.2024</option>
                        <option value="Y-m-d" {{ $settings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>2024-12-31</option>
                        <option value="d/m/Y" {{ $settings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>31/12/2024</option>
                        <option value="m/d/Y" {{ $settings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>12/31/2024</option>
                    </select>
                    <small class="gemini-help-text">Joriy: {{ now()->format($settings['date_format']) }}</small>
                </div>
                
                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-clock"></i>
                        Vaqt formati
                    </label>
                    <select name="time_format" class="gemini-select" required>
                        <option value="H:i" {{ $settings['time_format'] == 'H:i' ? 'selected' : '' }}>24:00 (24 soatlik)</option>
                        <option value="h:i A" {{ $settings['time_format'] == 'h:i A' ? 'selected' : '' }}>12:00 AM (12 soatlik)</option>
                        <option value="H:i:s" {{ $settings['time_format'] == 'H:i:s' ? 'selected' : '' }}>24:00:00 (soniya bilan)</option>
                    </select>
                    <small class="gemini-help-text">Joriy: {{ now()->format($settings['time_format']) }}</small>
                </div>

                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-sort-numeric-up"></i>
                        Raqam formati
                    </label>
                    <select name="number_format" class="gemini-select">
                        <option value="space" {{ ($settings['number_format'] ?? 'space') == 'space' ? 'selected' : '' }}>1 000 000 (probel)</option>
                        <option value="comma" {{ ($settings['number_format'] ?? 'space') == 'comma' ? 'selected' : '' }}>1,000,000 (vergul)</option>
                        <option value="dot" {{ ($settings['number_format'] ?? 'space') == 'dot' ? 'selected' : '' }}>1.000.000 (nuqta)</option>
                    </select>
                </div>
            </div>

            <!-- Tizim sozlamalari -->
            <div class="gemini-settings-section">
                <div class="gemini-section-header">
                    <i class="fas fa-server"></i>
                    <h3>Tizim sozlamalari</h3>
                </div>

                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-users"></i>
                        Sahifadagi yozuvlar soni
                    </label>
                    <select name="per_page" class="gemini-select">
                        <option value="10" {{ ($settings['per_page'] ?? '25') == '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ ($settings['per_page'] ?? '25') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ ($settings['per_page'] ?? '25') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($settings['per_page'] ?? '25') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-bell"></i>
                        Bildirishnomalar
                    </label>
                    <div class="gemini-checkbox-group">
                        <label class="gemini-checkbox">
                            <input type="checkbox" name="notifications[email]" {{ ($settings['notifications']['email'] ?? true) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            Email bildirishnomalar
                        </label>
                        <label class="gemini-checkbox">
                            <input type="checkbox" name="notifications[sms]" {{ ($settings['notifications']['sms'] ?? false) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            SMS bildirishnomalar
                        </label>
                    </div>
                </div>

                <div class="gemini-form-group">
                    <label class="gemini-label">
                        <i class="fas fa-shield-alt"></i>
                        Xavfsizlik
                    </label>
                    <div class="gemini-checkbox-group">
                        <label class="gemini-checkbox">
                            <input type="checkbox" name="security[two_factor]" {{ ($settings['security']['two_factor'] ?? false) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            Ikki bosqichli autentifikatsiya
                        </label>
                        <label class="gemini-checkbox">
                            <input type="checkbox" name="security[session_timeout]" {{ ($settings['security']['session_timeout'] ?? true) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            Sessiya vaqti cheklovi
                        </label>
                    </div>
                </div>
            </div>

            <!-- Tizim ma'lumotlari -->
            <div class="gemini-settings-section">
                <div class="gemini-section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Tizim ma'lumotlari</h3>
                </div>
                
                <div class="gemini-system-info">
                    <div class="gemini-info-row">
                        <span class="label">Laravel versiyasi:</span>
                        <span class="value">{{ app()->version() }}</span>
                    </div>
                    <div class="gemini-info-row">
                        <span class="label">PHP versiyasi:</span>
                        <span class="value">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="gemini-info-row">
                        <span class="label">Server vaqti:</span>
                        <span class="value">{{ now()->format('d.m.Y H:i:s') }}</span>
                    </div>
                    <div class="gemini-info-row">
                        <span class="label">Disk maydoni:</span>
                        <span class="value">{{ round(disk_free_space('/') / 1024 / 1024 / 1024, 2) }} GB</span>
                    </div>
                    <div class="gemini-info-row">
                        <span class="label">Xotira limiti:</span>
                        <span class="value">{{ ini_get('memory_limit') }}</span>
                    </div>
                </div>

                <div class="gemini-backup-section">
                    <h4>Zaxira nusxa</h4>
                    <div class="gemini-backup-actions">
                        <button type="button" class="gemini-btn gemini-btn-info" onclick="createBackup()">
                            <i class="fas fa-download"></i> Zaxira yaratish
                        </button>
                        <button type="button" class="gemini-btn gemini-btn-warning" onclick="restoreBackup()">
                            <i class="fas fa-upload"></i> Qayta tiklash
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="gemini-settings-footer">
            <div class="gemini-save-info">
                <i class="fas fa-info-circle"></i>
                O'zgarishlar darhol qo'llaniladi
            </div>
            <div class="gemini-form-actions">
                <button type="button" class="gemini-btn gemini-btn-secondary" onclick="window.location.reload()">
                    <i class="fas fa-times"></i> Bekor qilish
                </button>
                <button type="submit" class="gemini-btn gemini-btn-primary">
                    <i class="fas fa-save"></i> Sozlamalarni saqlash
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function resetSettings() {
    if (confirm('Barcha sozlamalarni standart holatga qaytarishni xohlaysizmi?')) {
        // Reset form to default values
        document.getElementById('settingsForm').reset();
    }
}

function createBackup() {
    alert('Zaxira nusxa yaratilmoqda...');
    // Implement backup functionality
}

function restoreBackup() {
    if (confirm('Zaxira nusxadan qayta tiklamoqchimisiz?')) {
        alert('Qayta tiklash jarayoni boshlandi...');
        // Implement restore functionality
    }
}

// Auto-save functionality
let saveTimeout;
document.getElementById('settingsForm').addEventListener('input', function() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        // Auto-save after 2 seconds of inactivity
        console.log('Auto-saving settings...');
    }, 2000);
});
</script>
@endsection
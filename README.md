# 🎓 Iftixor LMS - Learning Management System

Modern va to'liq funksional o'quv markazlari uchun boshqaruv tizimi. Laravel framework asosida qurilgan.

## ✨ Asosiy Imkoniyatlar

### 👥 Foydalanuvchi Boshqaruvi
- **Talabalar** - Ro'yxatdan o'tish, kurslar, davomat
- **O'qituvchilar** - Dars o'tkazish, baholar, hisobotlar  
- **Administratorlar** - To'liq tizim boshqaruvi
- **Menejerlar** - Filial va lead boshqaruvi

### 📚 Ta'lim Jarayoni
- Kurslar va guruhlar yaratish
- Dars jadvallari tuzish
- Davomat nazorati
- Video darslar va jonli translyatsiyalar
- Materiallar va testlar
- Sertifikatlar berish

### 💰 Moliyaviy Boshqaruv
- To'lovlar va chegirmalar
- Oylik maoshlar hisobi
- Xarajatlar nazorati
- Moliyaviy hisobotlar

### 🏢 Ko'p Filial Tizimi
- Markazlashtirilgan boshqaruv
- Filiallar bo'yicha statistika
- Alohida ma'lumotlar bazasi

## 🚀 O'rnatish

### Tizim Talablari
- PHP 8.1+
- MySQL/SQLite
- Composer
- Node.js (ixtiyoriy)

### Tez O'rnatish
```bash
# Loyihani klonlash
git clone https://github.com/username/iftixor-lms.git
cd iftixor-lms

# Bog'liqliklarni o'rnatish
composer install

# Muhit sozlamalari
cp .env.example .env
php artisan key:generate

# Ma'lumotlar bazasini sozlash
php artisan migrate --seed

# Serverni ishga tushirish
php artisan serve
```

### Avtomatik O'rnatish
```bash
# cPanel uchun
php cpanel-install.php

# Oddiy server uchun  
bash auto-setup.sh
```

## 📱 Texnologiyalar

- **Backend**: Laravel 10, PHP 8.1+
- **Frontend**: Blade Templates, Bootstrap
- **Ma'lumotlar bazasi**: MySQL/SQLite
- **Autentifikatsiya**: Laravel Sanctum
- **SMS**: Eskiz.uz integratsiyasi
- **Telegram**: Bot integratsiyasi

## 🔧 Konfiguratsiya

### Asosiy Sozlamalar
```env
APP_NAME="Iftixor LMS"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iftixor_lms

# SMS sozlamalari
SMS_LOGIN=your_login
SMS_PASSWORD=your_password

# Telegram bot
TELEGRAM_BOT_TOKEN=your_token
```

## 📊 Modullar

| Modul | Tavsif |
|-------|--------|
| **Talabalar** | Ro'yxat, profil, to'lovlar |
| **O'qituvchilar** | Darslar, baholar, maosh |
| **Kurslar** | Dastur, materiallar, testlar |
| **Guruhlar** | Jadval, davomat, statistika |
| **Moliya** | To'lovlar, xarajatlar, hisobotlar |
| **Leadlar** | Mijozlar bilan ishlash |
| **Sertifikatlar** | Avtomatik yaratish va berish |

## 🛡️ Xavfsizlik

- Parollar shifrlash (bcrypt)
- CSRF himoyasi
- SQL injection himoyasi
- Session boshqaruvi
- Foydalanuvchi sessiyalari nazorati

## 📈 Hisobotlar

- Moliyaviy hisobotlar
- Davomat statistikasi
- O'qituvchilar ish yuklari
- Talabalar o'zlashtirishi
- Filiallar bo'yicha tahlil

## 🤝 Hissa Qo'shish

1. Fork qiling
2. Feature branch yarating (`git checkout -b feature/yangi-imkoniyat`)
3. O'zgarishlarni commit qiling (`git commit -am 'Yangi imkoniyat qo'shildi'`)
4. Branch'ni push qiling (`git push origin feature/yangi-imkoniyat`)
5. Pull Request yarating

## 📞 Yordam

- **Email**: support@iftixor.uz
- **Telegram**: @iftixor_support
- **Dokumentatsiya**: [docs.iftixor.uz](https://docs.iftixor.uz)

## 📄 Litsenziya

MIT litsenziyasi ostida tarqatiladi. Batafsil ma'lumot uchun [LICENSE](LICENSE) faylini ko'ring.

---

<div align="center">
  <strong>Iftixor LMS</strong> - Zamonaviy ta'lim uchun zamonaviy yechim
</div>
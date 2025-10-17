# CPanel ga O'rnatish Bo'yicha Qo'llanma

## .env Faylsiz Ishlash

Endi loyiha .env faylsiz to'liq ishlaydi. Barcha sozlamalar avtomatik aniqlanadi:

### Avtomatik Sozlamalar:
- **Database**: SQLite avtomatik topiladi yoki yaratiladi
- **APP_URL**: Domen avtomatik aniqlanadi  
- **APP_ENV**: Production/Local avtomatik
- **APP_DEBUG**: Production da false, local da true
- **Storage**: Avtomatik sozlanadi

## CPanel ga O'rnatish

### 1-qadam: Fayllarni yuklash
```bash
# Barcha fayllarni CPanel File Manager orqali yuklang
# yoki FTP orqali root papkaga yuklang
```

### 2-qadam: Avtomatik sozlash
```bash
# CPanel Terminal yoki SSH orqali:
php auto-config.php
```

### 3-qadam: Tayyor!
Saytingiz ishlay boshlaydi. Database avtomatik yaratiladi.

## Database Yo'llari (Avtomatik)

Tizim quyidagi tartibda database qidiradi:
1. `/home/username/database/database.sqlite` (CPanel)
2. `/home/username/private/database.sqlite` (CPanel private)
3. `./database/database.sqlite` (Local)

## Xususiyatlar

✅ .env faylsiz ishlaydi  
✅ CPanel avtomatik moslashadi  
✅ Database yo'li avtomatik topiladi  
✅ Server almashganda oson o'tkazish  
✅ Xavfsiz sozlamalar  

## Muammolar

Agar muammo bo'lsa:
1. `php auto-config.php` qayta ishga tushiring
2. `storage` papka ruxsatlarini tekshiring (755)
3. Database papkasi mavjudligini tekshiring

## Qo'shimcha

- Barcha cache avtomatik tozalanadi
- Storage link avtomatik yaratiladi  
- .htaccess avtomatik sozlanadi
- Ruxsatlar avtomatik o'rnatiladi
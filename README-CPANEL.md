# cPanel Upload Instructions

## 1. Upload Files
- Upload all files EXCEPT `public` folder to your cPanel root directory
- Upload contents of `public_html` folder to your cPanel `public_html` directory

## 2. File Structure on cPanel
```
/home/username/
├── public_html/           # Web accessible files
│   ├── index.php         # Laravel entry point
│   ├── .htaccess         # URL rewriting
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   └── images/           # Images
├── app/                  # Laravel application
├── config/               # Configuration files
├── database/             # SQLite database files
├── vendor/               # Composer dependencies
├── storage/              # Laravel storage
└── bootstrap/            # Laravel bootstrap
```

## 3. Run Setup
1. Visit: `yourdomain.com/cpanel-setup.php`
2. Delete the setup file after completion

## 4. Database Location
The system will automatically find SQLite database in:
- `/home/username/database/`
- `/home/username/private/`

## 5. No .env Required
The system works without .env file and auto-detects:
- Database paths
- App URL (HTTP/HTTPS)
- Production/Development mode

## 6. Permissions
Ensure these folders are writable (755):
- `storage/`
- `bootstrap/cache/`
#!/bin/bash

# Ruxsatlarni asl holatiga qaytarish

echo "Ruxsatlar asl holatiga qaytarilmoqda..."

# Storage papka - standart ruxsatlar
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;

# Public_html - standart web ruxsatlari
find public_html -type d -exec chmod 755 {} \;
find public_html -type f -exec chmod 644 {} \;

# PHP fayllar uchun
find . -name "*.php" -exec chmod 644 {} \;

# Storage linkini o'chirish
if [ -L "public_html/storage" ]; then
    rm public_html/storage
fi

# Database standart ruxsatlari
chmod 644 database/*.sqlite 2>/dev/null || true
chmod 755 database/ 2>/dev/null || true

# Script fayllar
chmod 644 *.sh 2>/dev/null || true

echo "Ruxsatlar asl holatiga qaytarildi ✓"
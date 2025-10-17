#!/bin/bash

# CPanel da rasm va fayllar ko'rinishi uchun ruxsatlarni sozlash

echo "Ruxsatlar sozlanmoqda..."

# Storage papka va ichidagi barcha fayllar
find storage -type d -exec chmod 755 {} \;
find storage -type f -exec chmod 644 {} \;

# Public_html papka va rasmlar
find public_html -type d -exec chmod 755 {} \;
find public_html -type f -exec chmod 644 {} \;

# Rasmlar papkalari
chmod -R 755 public_html/images/
chmod -R 644 public_html/images/*
chmod -R 755 public_html/css/
chmod -R 644 public_html/css/*
chmod -R 755 public_html/js/
chmod -R 644 public_html/js/*

# Storage link
if [ -L "public_html/storage" ]; then
    rm public_html/storage
fi
ln -sf ../storage/app/public public_html/storage
chmod 755 public_html/storage

# Storage/app/public papka
mkdir -p storage/app/public
chmod -R 755 storage/app/public/

# Database ruxsatlari
chmod 644 database/*.sqlite 2>/dev/null || true
chmod 755 database/ 2>/dev/null || true

echo "Ruxsatlar sozlandi ✓"
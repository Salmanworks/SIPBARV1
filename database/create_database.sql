-- ===================================================================
-- SQL Script untuk Membuat Database SIPBAR
-- ===================================================================

-- Buat database baru dengan charset UTF-8
CREATE DATABASE IF NOT EXISTS sipbar
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Gunakan database
USE sipbar;

-- Informasi database
SELECT 
    'Database SIPBAR berhasil dibuat!' AS status,
    'sipbar' AS nama_database,
    'utf8mb4_unicode_ci' AS collation;

-- ===================================================================
-- SELESAI!
-- Sekarang jalankan migration Laravel:
-- php artisan migrate --seed
-- ===================================================================

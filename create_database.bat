@echo off
echo ================================================================
echo MEMBUAT DATABASE SIPBAR
echo ================================================================
echo.

REM Cari MySQL di lokasi umum
set MYSQL_PATH=

if exist "C:\xampp\mysql\bin\mysql.exe" (
    set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe
    echo [OK] MySQL ditemukan di XAMPP
) else if exist "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" (
    set MYSQL_PATH=C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe
    echo [OK] MySQL ditemukan di Program Files
) else if exist "C:\wamp64\bin\mysql\mysql8.0.31\bin\mysql.exe" (
    set MYSQL_PATH=C:\wamp64\bin\mysql\mysql8.0.31\bin\mysql.exe
    echo [OK] MySQL ditemukan di WAMP
) else (
    echo [ERROR] MySQL tidak ditemukan!
    echo.
    echo Silakan install MySQL atau pastikan MySQL sudah ada di:
    echo - C:\xampp\mysql\bin\mysql.exe
    echo - C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe
    echo - C:\wamp64\bin\mysql\...\bin\mysql.exe
    echo.
    echo Atau gunakan phpMyAdmin untuk membuat database manual.
    pause
    exit /b 1
)

echo.
echo Membuat database 'sipbar'...
echo.

"%MYSQL_PATH%" -u root -p123456 -e "CREATE DATABASE IF NOT EXISTS sipbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if %errorlevel% equ 0 (
    echo.
    echo [OK] Database 'sipbar' berhasil dibuat!
    echo.
    echo Langkah selanjutnya:
    echo 1. Jalankan: php artisan migrate --seed
    echo 2. Jalankan: php artisan serve
    echo 3. Buka browser: http://localhost:8000
    echo.
) else (
    echo.
    echo [ERROR] Gagal membuat database!
    echo.
    echo Kemungkinan penyebab:
    echo - Password MySQL salah (coba ubah di file ini)
    echo - MySQL service tidak running
    echo.
    echo Solusi alternatif:
    echo 1. Buka phpMyAdmin: http://localhost/phpmyadmin
    echo 2. Klik tab "SQL"
    echo 3. Copy-paste SQL ini:
    echo    CREATE DATABASE sipbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    echo 4. Klik "Go"
    echo.
)

pause

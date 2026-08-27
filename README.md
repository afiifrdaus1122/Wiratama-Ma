# Wiratama-MA

Aplikasi e-commerce Laravel untuk PT Wiratama Mitra Abadi.

## Deployment Hostinger

1. Gunakan PHP 8.2 atau lebih baru dan aktifkan ekstensi PHP Laravel.
2. Upload project Laravel ke folder di luar `public_html`, misalnya `~/wiratama-ma`.
3. Set document root domain/subdomain ke `~/wiratama-ma/public`.
4. Buat `.env` production secara manual. Jangan upload `.env` lokal.
5. Atur `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`, `APP_KEY`, database MySQL Hostinger, dan konfigurasi email production.
6. Jalankan dari Terminal Hostinger di folder project:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. Pastikan `storage` dan `bootstrap/cache` dapat ditulis oleh web server.
8. Upload `public/build` hasil `npm run build` bersama folder `public`.
9. Jangan upload `node_modules`, `.git`, cache test, atau file `.env` lokal.
10. Pastikan `public/storage` mengarah ke `storage/app/public`. Jika symbolic link tidak diizinkan, salin isi folder tersebut ke `public/storage`.

## Pengembangan Lokal

```bash
composer install
npm install
npm run build
php artisan serve
```

Gunakan `npm run dev` hanya untuk development. Sebelum upload production, jalankan `npm run build` dan pastikan file `public/hot` tidak ada.

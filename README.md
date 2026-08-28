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

## Backup Database Otomatis

Aplikasi menyediakan command `backup:database` yang membuat backup SQL gzip di `storage/app/backups`.
Backup lama lebih dari 14 hari akan dihapus otomatis.

Jalankan backup manual sebelum perubahan besar:

```bash
php artisan backup:database --keep=14
```

Di Hostinger, buat cron job yang menjalankan scheduler Laravel setiap menit:

```bash
* * * * * cd /home/USERNAME/wiratama-ma && php artisan schedule:run >> /dev/null 2>&1
```

Scheduler akan membuat backup database setiap hari pukul 02:00. Ganti `USERNAME` dan path project sesuai akun Hostinger.

Setiap perubahan data melalui halaman admin juga otomatis membuat backup sebelum proses simpan atau hapus. Jika backup gagal, perubahan dibatalkan agar tidak ada perubahan tanpa titik pemulihan.

Untuk restore, ekstrak file `.sql.gz`, lalu import file `.sql` melalui phpMyAdmin atau MySQL. Selalu simpan salinan backup di luar server juga.

## Pengembangan Lokal

```bash
composer install
npm install
npm run build
php artisan serve
```

Gunakan `npm run dev` hanya untuk development. Sebelum upload production, jalankan `npm run build` dan pastikan file `public/hot` tidak ada.

### Menjaga Data Database

Perubahan kode maupun `npm run dev` tidak menghapus data. Saat ada migration baru, jalankan:

```bash
php artisan backup:database --keep=14
php artisan migrate
```

Jangan gunakan `php artisan migrate:fresh`, `php artisan migrate:refresh`, atau `php artisan db:wipe` pada database yang berisi data karena perintah tersebut menghapus tabel atau seluruh isinya. Pastikan juga `.env` tetap memakai koneksi dan nama database yang sama.

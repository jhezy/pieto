Pieto POS - Aplikasi Kasir Berbasis Laravel
Pieto POS adalah aplikasi kasir berbasis web yang dibangun menggunakan Laravel dengan pendekatan model POS (Point of Sale). Aplikasi ini dirancang untuk mempermudah proses transaksi penjualan, manajemen produk, dan pencetakan struk secara efisien dan modern.
✨ Fitur Unggulan
• Manajemen produk (tambah, edit, hapus)
• Sistem keranjang belanja (shopping cart)
• Proses checkout & pembayaran dalam satu tampilan (modal)
• Pencetakan struk otomatis menggunakan html2pdf.js
• Laporan transaksi harian
• Desain responsif, cocok untuk desktop maupun tablet
🧰 Persyaratan Instalasi
• PHP >= 8.1
• Composer
• MySQL atau MariaDB
• Node.js & npm
• Laravel CLI (composer global require laravel/installer)
🚀 Cara Install dan Setup Pieto POS

1. Clone Proyek dari GitHub
   git clone https://github.com/jhezy/pieto-pos.git
   cd pieto-pos
2. Install Dependensi Laravel
   composer install
3. Copy File Environment
   cp .env.example .env
4. Generate App Key
   php artisan key:generate
5. Konfigurasi Database
   Edit file .env dan sesuaikan:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pieto_db
DB_USERNAME=root
DB_PASSWORD= 6. Jalankan Migrasi dan Seeder (Opsional)
php artisan migrate --seed 7. Install dan Build Aset Front-End
npm install
npm run dev

Untuk mode produksi gunakan:
npm run build 8. Jalankan Server Laravel
php artisan serve

Akses: http://127.0.0.1:8000
⚠️ Catatan Tambahan
• Pastikan layanan database berjalan sebelum melakukan migrasi.
• Jika ada kendala permission, jalankan: chmod -R 775 storage bootstrap/cache
• Untuk pencetakan struk, pastikan fitur pop-up dan akses PDF tidak diblokir oleh browser.
📄 Lisensi
Aplikasi ini dirilis di bawah lisensi MIT.
Pieto POS - Aplikasi Kasir Berbasis Laravel
Pieto POS adalah aplikasi kasir berbasis web yang dibangun menggunakan Laravel dengan pendekatan model POS (Point of Sale). Aplikasi ini dirancang untuk mempermudah proses transaksi penjualan, manajemen produk, dan pencetakan struk secara efisien dan modern.
✨ Fitur Unggulan
• Manajemen produk (tambah, edit, hapus)
• Sistem keranjang belanja (shopping cart)
• Proses checkout & pembayaran dalam satu tampilan (modal)
• Pencetakan struk otomatis menggunakan html2pdf.js
• Laporan transaksi harian
• Desain responsif, cocok untuk desktop maupun tablet
🧰 Persyaratan Instalasi
• PHP >= 8.1
• Composer
• MySQL atau MariaDB
• Node.js & npm
• Laravel CLI (composer global require laravel/installer)
🚀 Cara Install dan Setup Pieto POS

1. Clone Proyek dari GitHub
   git clone https://github.com/jhezy/pieto-pos.git
   cd pieto-pos
2. Install Dependensi Laravel
   composer install
3. Copy File Environment
   cp .env.example .env
4. Generate App Key
   php artisan key:generate
5. Konfigurasi Database
   Edit file .env dan sesuaikan:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pieto_db
DB_USERNAME=root
DB_PASSWORD= 6. Jalankan Migrasi dan Seeder (Opsional)
php artisan migrate --seed 7. Install dan Build Aset Front-End
npm install
npm run dev

Untuk mode produksi gunakan:
npm run build 8. Jalankan Server Laravel
php artisan serve

Akses: http://127.0.0.1:8000
⚠️ Catatan Tambahan
• Pastikan layanan database berjalan sebelum melakukan migrasi.
• Jika ada kendala permission, jalankan: chmod -R 775 storage bootstrap/cache
• Untuk pencetakan struk, pastikan fitur pop-up dan akses PDF tidak diblokir oleh browser.
📄 Lisensi
Aplikasi ini dirilis di bawah lisensi MIT.

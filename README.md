# <img src="https://seeklogo.com/images/L/laravel-logo-9B01588B1F-seeklogo.com.png" width="24px"> Laravel Rebuild ☄️

> This readme is written in Bahasa. [English version is here](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/README.EN.md).

## Deskripsi

*Artisan command* untuk me-*rebuild* aplikasi Laravel.

## Motivasi

Proses rebuild aplikasi cukup memakan waktu dengan melakukan rangkaian perintah artisan seperti: clearing caches, making fresh database schema, seeding initial data, seeding dummy data (if any), importing files (if any), dsb. *Artisan command* ini akan mempermudahnya.

## Instalasi

```
composer require bukankalengkaleng/laravel-rebuild
```

Laravel v5.5 dan keatas akan otomatis meregistrasi package ini. Jika kamu menggunakan versi dibawah itu, kamu perlu melakukannya secara manual dalam file `config/app.php`:

```php
'providers' => [
    // ...
    BukanKalengKaleng\LaravelRebuild\LaravelRebuildServiceProvider::class,
];
```

## Cara Menggunakan

1. Jalankan artisan `rebuild` seperti berikut:
    ```
    php artisan rebuild
    ```
1. Proses *rebuilding* aplikasi yang akan dilakukan adalah sebagai berikut:
    - ???

Proses *rebuilding* diatas dapat kamu atur dalam `config/rebuild.php`, yang harus kamu publish dahulu dengan cara:

```
php artisan vendor:publish --tag="laravel-rebuild"
```

## Roadmap

Untuk mengetahui rencana kedepan package ini silahkan membaca [Roadmap](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/ROADMAP.md).

## Kontribusi

1. Kirim PR
1. Gak perlu baper kalo PR tertolak

## Catatan Revisi

Catatan revisi dapat dilihat di [Changelog](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/CHANGELOG.md) ini.

## Lisensi

Lisensi dari package ini adalah MIT License (MIT). Silahkan lihat bagian [Lisensi](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/LICENSE.md) ini untuk lebih jelasnya.

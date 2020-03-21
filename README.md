# Laravel Rebuild 🏗

This readme is written in Bahasa. [English version is here.](README.EN.md)

|     | Status |
| --- | --- |
| Release | [![Latest Stable Version](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/v/stable)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) [![Total Downloads](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/downloads)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) [![License](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/license)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) |
| Code Quality | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-rebuild/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-rebuild/?branch=master) [![codecov](https://codecov.io/gh/bukankalengkaleng/laravel-rebuild/branch/master/graph/badge.svg)](https://codecov.io/gh/bukankalengkaleng/laravel-rebuild) [![Code Intelligence Status](https://scrutinizer-ci.com/g/bukankalengkaleng/laravel-rebuild/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) |
| Development | [![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-rebuild.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-rebuild) [![Maintainability](https://api.codeclimate.com/v1/badges/54cf95d1014227c6e4c0/maintainability)](https://codeclimate.com/github/bukankalengkaleng/laravel-rebuild/maintainability) [![Test Coverage](https://api.codeclimate.com/v1/badges/54cf95d1014227c6e4c0/test_coverage)](https://codeclimate.com/github/bukankalengkaleng/laravel-rebuild/test_coverage) |

---

## Deskripsi

Artisan *command* untuk me-*rebuild* aplikasi Laravel.

## Motivasi

Proses *rebuild* aplikasi cukup memakan waktu dengan melakukan rangkaian perintah artisan seperti: *clearing caches, making fresh database schema, seeding initial data, seeding dummy data (if any), importing files (if any)*, dsb.  

Artisan *command* ini akan mempermudahnya.

## Instalasi

1. Jalankan perintah:

    ```bash
    composer require --dev bukankalengkaleng/laravel-rebuild
    ```

    Laravel v5.5 dan keatas akan otomatis meregistrasi package ini. Jika kamu menggunakan versi dibawah itu, kamu perlu melakukannya secara manual dalam file `config/app.php`:

    ```php
    'providers' => [
        // ...
        BukanKalengKaleng\LaravelRebuild\LaravelRebuildServiceProvider::class,
    ];
    ```

1. Pastikan aplikasi sudah bisa konek ke *database*

## Cara Menggunakan

1. Jalankan perintah:

    ```bash
    php artisan rebuild
    ```

1. Proses *rebuilding* aplikasi yang akan dilakukan adalah sebagai berikut:
    - Re-create database schema
    - Seeding initial data
    - Seeding dummy data, jika ada
    - Seeding example data, jika ada
    - Cache clear
    - Config clear
    - Route clear
    - View clear
    - Flush expired passwords
    - Compiled files clear
    - Rebuild packages
    - Create symbolic link
    - Self diagnosis

Proses *rebuilding* diatas dapat kamu atur dalam `config/rebuild.php`, yang harus kamu *publish* dahulu dengan cara:

```bash
php artisan vendor:publish --tag="laravel-rebuild"
```

## Screenshots

<img src="screenshots/01.png" width="45%"> <img src="screenshots/02.png" width="45%">

## Roadmap

Untuk mengetahui rencana kedepan package ini silahkan membaca [Roadmap](ROADMAP.md).

## Kontribusi [![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/bukankalengkaleng/laravel-rebuild/issues)

1. Kirim PR
1. Gak perlu baper kalo PR tertolak

## Catatan Revisi

Catatan revisi dapat dilihat di [Changelog](CHANGELOG.md) ini.

## Lisensi

Lisensi dari package ini adalah MIT License (MIT). Silahkan lihat bagian [Lisensi](LICENSE.md) ini untuk lebih jelasnya.

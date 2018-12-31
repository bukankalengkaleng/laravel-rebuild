<p align="center"><img src="screenshots/logo.png" width="50%"></p>

<p align="center">Readme ini ditulis dalam bahasa Inggris. <a href="https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/README.md">Versi bahasa Indonesianya ada disini</a>.</p>

---

[![License](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/license)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) 
[![composer.lock](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/composerlock)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) 
[![Latest Stable Version](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/v/stable)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) 
[![Total Downloads](https://poser.pugx.org/bukankalengkaleng/laravel-rebuild/downloads)](https://packagist.org/packages/bukankalengkaleng/laravel-rebuild) 
[![Build Status](https://travis-ci.org/bukankalengkaleng/laravel-rebuild.svg?branch=master)](https://travis-ci.org/bukankalengkaleng/laravel-rebuild)

## Description

An artisan command to rebuild your app.

## Motivation

The rebuilding process of your app could take a time, by running artisan commands to do a clearing caches, making fresh database schema, seeding initial data, seeding dummy data (if any), importing files (if any), etc. This artisan command will make it easier.

## Installation

1. Run this command:
    ```
    composer require --dev bukankalengkaleng/laravel-rebuild
    ```

    In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

    ```php
    'providers' => [
        // ...
        BukanKalengKaleng\LaravelRebuild\LaravelRebuildServiceProvider::class,
    ];
    ```
1. Make sure the connection to the database

## Usage

1. Run `rebuild` artisan command
    ```
    php artisan rebuild
    ```
1. The rebuilding process will take actions as follow:
    - Re-create database schema
    - Seeding initial data
    - Seeding dummy data, if any
    - Seeding example data, if any
    - Cache clear
    - Config clear
    - Route clear
    - View clear
    - Flush expired passwords
    - Compiled files clear
    - Rebuild packages
    - Create symbolic link
    - Self diagnosis

You can adjust how rebuilding process will take action via `config/rebuild.php` file, which you have to publish first:

```
php artisan vendor:publish --tag="laravel-rebuild"
```

## Screenshots

<img src="screenshots/02.png" width="75%">

## Roadmap

All planning goes to [Roadmap](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/ROADMAP.md) file.

## Contributing [![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/bukankalengkaleng/laravel-rebuild/issues)

1. Send PR
1. Please do not take it personal if your PR got rejected

## Changelog

Notable changes are documented in [Changelog](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/CHANGELOG.md) file.

## License

The MIT License (MIT). Please see [License](https://github.com/bukankalengkaleng/laravel-rebuild/blob/master/LICENSE.md) file for more information.

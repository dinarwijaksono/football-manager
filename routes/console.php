<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('migrate:fresh-test', function () {
    config(['database.default' => 'mysql-test']);

    Artisan::call('migrate:fresh');

    $this->comment("Berhasil...");
})->purpose('Migrate fresh in database test.');

Artisan::command('tailwind-start', function () {

    system("npx tailwind -i ./resources/css/app.css -o ./public/zara/style.css --watch");
})->purpose('Run tailwind');

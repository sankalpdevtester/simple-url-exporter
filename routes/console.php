<?php

use Illuminate\Console\Scheduling\Scheduler;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/console', function () {
    // ...
})->name('console');

Route::command('export:urls', \App\Console\Commands\ExportUrlsCommand::class);
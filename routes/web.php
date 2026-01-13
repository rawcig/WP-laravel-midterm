<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('backend.index');
});

Route::get('/app-profile', function () {
    return view('backend.pages.app-profile');
})->name('app-profile');
Route::get('/create-event', function () {
    return view('backend.pages.home-create-event');
})->name('create-event');

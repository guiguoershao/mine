<?php
use guiguoershao\Route\Route;

/**
 * 应用实例
 * php index.php any /home
 */




Route::any('/', function () {
    echo 'Hello World';
});

Route::any('/home', 'Test@index');
Route::any('/publish', 'Test@publish');
Route::any('/subscribe', 'Test@subscribe');
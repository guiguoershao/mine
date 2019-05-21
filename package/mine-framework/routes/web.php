<?php

use guiguoershao\Route\Route;

Route::getInstance()->get('/', function (\guiguoershao\Http\Request $request) {
    print_r($request->input()->get('a'));
    echo 'Hello World';
});
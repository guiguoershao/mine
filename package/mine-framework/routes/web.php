<?php

use guiguoershao\Route\Route;


Route::get('/', function () {
    echo 'Hello World';
});

Route::get('home', 'HomeController@index');
Route::get('redis', 'HomeController@redis');

Route::get('/coroutines', function () {
    dump(time());
    ob_implicit_flush(1);
    @ob_end_clean();
    function task1() {
        for ($i = 1; $i <= 5; ++$i) {
            sleep(1);
            var_dump("This is task 1 iteration $i.");
            yield; // 主动让出CPU的执行权
        }
    }

    function task2() {
        for ($i = 1; $i <= 5; ++$i) {
            sleep(1);
            var_dump("This is task 2 iteration $i.");
            yield; // 主动让出CPU的执行权
        }
    }

    $scheduler = new \Library\Coroutines\Scheduler();
    $scheduler->addTask(task1());
    $scheduler->addTask(task2());
    $scheduler->run();

    dd(time());
});
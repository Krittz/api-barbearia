<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return abort(403, "Sai fora cuzaum");
});

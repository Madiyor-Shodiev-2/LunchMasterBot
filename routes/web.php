<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function (Request $request) {
    // Log::info("That's working", [
    //     'url' => '/'
    // ]);
    return "Hello World";
});
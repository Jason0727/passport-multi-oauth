<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['multiauth:admin']], function () {
    Route::get('/adminInfo', function (Request $request) {
        // return \Illuminate\Support\Facades\Auth::user();
        return $request->user();
    });
});
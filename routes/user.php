<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['multiauth:user']], function () {
    Route::get('/userInfo', function (Request $request) {
        // return \Illuminate\Support\Facades\Auth::user();
        return $request->user();
    });
});
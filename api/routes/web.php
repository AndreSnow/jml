<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn (): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response => response('OK', 200));

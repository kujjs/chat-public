<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', 'ChatController@index')->where('any', '.*');

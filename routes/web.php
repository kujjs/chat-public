<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')->name('home.comment')->group(function (){
    Route::get('','CommentController@index');
    Route::post('','CommentController@store');
    Route::post('file','CommentController@upload')->name('.upload');

});

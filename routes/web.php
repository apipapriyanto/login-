<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});

Route::group(['prefix'=>'admin', 'middleware'=>['auth','role:admin']], function () {
    // Route diisi disini...
    Route::get('/', function(){
        return view('admin.index');
    });

});

Route::group(['prefix'=>'user', 'middleware'=>['auth','role:user']], function () {
    // Route diisi disini...
    Route::get('/', function(){
        return view('user.index');
    });

});

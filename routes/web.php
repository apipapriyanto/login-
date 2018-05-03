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

use App\User;

Route::get('/create_posts', function() {
  // $user = User::create([
  //   'name' => 'Apip Apriyanto',
  //   'email' => 'apip@apip.com',
  //   'password' => bcrypt('rahasia')
  // ]);

  $user = User::findOrFail(1);

  $user->posts()->create([
    'title' => 'Judul',
    'body' => 'Hello Word! Ini isi body dari Post'
  ]);

  return 'Success';

});

Route::get('/read_posts', function() {
  $user = User::find(1);

  $posts = $user->posts()->get();

  foreach ($posts as $post) {
    $data[] = [
      'name' => $post->user->name,
      'email' => $post->user->email,
      'title' => $post->title,
      'body' => $post->body
    ];
  }

  return $data;

});

Route::get('/update_posts', function() {
  $user = User::findOrFail(1);

  $user->posts()->whereId(1)->update([
         'title' => 'Kita Update Title',
         'body' => 'Termasuk Body pun kita Update'
       ]);

  return 'Success';
});

Route::get('/delete_posts', function() {
  $user = User::find(1);

  $user->posts()->whereId(2)->delete();

  return 'Success';
});

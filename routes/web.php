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

use App\Profile;

Route::get('/create_user', function() {
  $user = User::create([
    'name' => 'Dimas Damai',
    'email' => 'dimas@apip.com',
    'password' => bcrypt('rahasia')
  ]);

  return $user;
});

Route::get('/create_profile', function() {
  // $profile = Profile::create([
  //   'user_id' => 1,
  //   'phone' => '123456789',
  //   'address' => 'Sambongsari, Weleri'
  // ]);

  $user = User::find(1);
  $profile = new Profile([
    'phone' => '123456789',
    'address' => 'Sambongsari, Weleri'
  ]);

  $user->profile()
       ->save($profile);

  return $user;
});

Route::get('/create_user_profile', function() {
  $user = User::find(2);

  $profile = new Profile([
    'phone' => '123456789',
    'address' => 'Losewusari, Weleri'
  ]);

  $user->profile()
       ->save($profile);

  return $user;
});

Route::get('/read_user', function() {
  $user = User::find(1);

  $data = [
    'name' => $user->name,
    'phone' => $user->profile->phone,
    'address' => $user->profile->address
  ];

  return $data;
});

Route::get('/read_profile', function() {
  $profile = Profile::where('address', 'Losewusari, Weleri')
                    ->first();

  $data = [
    'name' => $profile->user->name,
    'email' => $profile->user->email,
    'phone' => $profile->phone,
    'address' => $profile->address
  ];

  return $data;
});

Route::get('/update_profile', function() {
  $user = User::find(1);

  $user->profile()->update([
    'phone' => '987654321',
    'address' => 'Losewusari, Weleri'
  ]);

  return $user;
});

Route::get('/delete_profile', function() {
  $user = User::find(1);

  $user->profile()->delete();

});

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('posts', 'PostController@index')->name('posts.index');

Route::get('asd', 'HomeController@tes')->name('ngetes');

//Mejadikan Route dalam satu group
Route::middleware('auth')->group(function () {
  //Melakukan Create ke database
  Route::get('posts/create', 'PostController@create')->name('posts.create');
  Route::post('posts/store', 'PostController@store');

  //Melakukan Update ke database
  Route::get('posts/{post:slug}/edit', 'PostController@edit');
  Route::patch('posts/{post:slug}/edit', 'PostController@update');

  //Melakukan Delete ke database
  Route::delete('posts/{post:slug}/delete', 'PostController@destroy');
});


Route::get('posts/{post:slug}', 'PostController@show');

//Menampilkan berdasarkan category
Route::get('categories/{category:slug}', 'CategoryController@show');
Route::get('tags/{tag:slug}', 'TagController@show');

Route::view('contact', 'contact');
Route::view('about', 'about');
Route::view('login', 'login');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/tes', 'PostController@test')->name('aye');

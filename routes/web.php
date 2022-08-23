<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', [\App\Http\Controllers\Repository::class, 'index']);
Route::get('/getRepoDetails/{id}', [\App\Http\Controllers\Repository::class, 'getRepoDetails']);
Route::get('/updateRepos', [\App\Http\Controllers\Repository::class, 'updateRepositories']);

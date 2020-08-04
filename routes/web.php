<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/role-register', 'Admin\DashboardController@registered');
    Route::get('/role-edit/{id}', 'Admin\DashboardController@registeredit');
    Route::put('/role-register-update/{id}', 'Admin\DashboardController@registerupdate');
    Route::delete('/role-delete/{id}', 'Admin\DashboardController@registerdelete');

    Route::get('/issues', 'Admin\IssuesController@index');
    Route::get('/closed', 'Admin\IssuesController@closed');
    Route::get('/defer', 'Admin\IssuesController@defer');
    Route::post('/issues-filter-news', 'Admin\IssuesController@getReport');
    Route::post('/issues-filter-defers', 'Admin\IssuesController@getReportdefers');
    Route::post('/issues-filter-closed', 'Admin\IssuesController@getReportclosed');
    Route::get('/issues-create', 'Admin\IssuesController@create');
    Route::post('/issues-store', 'Admin\IssuesController@store')->name('issues-store');
    Route::get('/issues-edit/{id}', 'Admin\IssuesController@edit');
    Route::put('/issues-update/{id}', 'Admin\IssuesController@update');
    Route::get('/issues-show/{id}', 'Admin\IssuesController@show');

    Route::get('/abouts', 'Admin\AboutusController@index');
    Route::post('/save-aboutus', 'Admin\AboutusController@store');
    Route::put('/aboutus-update/{id}', 'Admin\AboutusController@update');
    Route::get('/about-us/{id}', 'Admin\AboutusController@edit');
    Route::delete('/about-us-delete/{id}', 'Admin\AboutusController@delete');

    Route::get('/category', 'Admin\CategoryController@index');
    Route::post('/category-store', 'Admin\CategoryController@store');
    Route::get('/category-edit/{id}', 'Admin\CategoryController@edit');
    Route::put('/category-update/{id}', 'Admin\CategoryController@update');
    Route::get('/category-create', 'Admin\CategoryController@create');
    Route::delete('/category-delete/{id}', 'Admin\CategoryController@delete');

    Route::get('/category-list', 'Admin\CategorylistController@index');
    Route::get('/category-list-edit/{id}', 'Admin\CategorylistController@edit');
    Route::post('/category-list-add', 'Admin\CategorylistController@store');
    Route::put('/category-list-update/{id}', 'Admin\CategorylistController@update');
});

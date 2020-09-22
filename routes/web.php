<?php

use Illuminate\Support\Facades\Artisan;
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

Route::post('/login-issues', 'Auth\LoginController@login');

// Route::group(['middleware' => ['auth', 'admin']], function () {


//PDF
Route::get('pdf/{id}','Admin\PDFController@pdf');


// Dashboard
Route::get('/dashboard', 'Admin\DashboardController@index');
Route::post('/dashboard-between', 'Admin\DashboardController@getReport');

// DashboardUser
Route::get('/dashboarduser', 'User\DashboardController@index');
Route::post('/dashboarduser-between', 'User\DashboardController@getReport');

// Role
Route::get('/role-register', 'Admin\RoleController@registered');
Route::get('/create-user', 'Admin\RoleController@registeredcreate');
Route::post('/register-create', 'Admin\RoleController@registerstore');
Route::get('/changActive', 'Admin\RoleController@changActive')->name('change_active');
Route::get('/role-edit/{id}', 'Admin\RoleController@registeredit');
Route::get('/role-reset/{id}', 'Admin\RoleController@registerreset');
Route::put('/role-register-update/{id}', 'Admin\RoleController@registerupdate');
Route::delete('/role-delete/{id}', 'Admin\RoleController@registerdelete');

//History Logs
Route::get('/history', 'Admin\LogsController@index');

//Historyuser Logs
Route::get('/historyuser', 'User\LogsController@index');

//issues//
Route::get('/issues', 'Admin\IssuesController@index');
Route::get('/closed', 'Admin\IssuesController@closed');
Route::get('/defer', 'Admin\IssuesController@defer');
Route::post('/issues-filter-news', 'Admin\IssuesController@getReport');
Route::post('/issues-filter-defers', 'Admin\IssuesController@getReportdefers');
Route::post('/issues-filter-closed', 'Admin\IssuesController@getReportclosed');
Route::get('/issues-edit/{id}', 'Admin\IssuesController@edit',function(){
    Artisan::call('storage:link');
});
Route::put('/issues-update/{id}', 'Admin\IssuesController@update',function(){
    Artisan::call('storage:link');
});
Route::get('/issues-show/{id}', 'Admin\IssuesController@show',function(){
    Artisan::call('storage:link');
});
Route::get('/dynamic/fetch', 'Admin\IssuesController@fetch')->name('dynamiccontroller.fetch');
Route::get('/findid', 'Admin\IssuesController@findid');
Route::get('/findidother', 'Admin\IssuesController@findidother');
Route::get('/issues-create', 'Admin\IssuesController@create');
Route::post('/issues-store', 'Admin\IssuesController@store')->name('issues-store');

//issuesuser//
Route::get('/issues-user', 'User\IssuesController@index');
Route::get('/closed-user', 'User\IssuesController@closed');
Route::get('/defer-user', 'User\IssuesController@defer');
Route::post('/issues-filter-news-user', 'User\IssuesController@getReport');
Route::post('/issues-filter-defers-user', 'User\IssuesController@getReportdefers');
Route::post('/issues-filter-closed-user', 'User\IssuesController@getReportclosed');
Route::get('/issues-edit-user/{id}', 'User\IssuesController@edit',function(){
    Artisan::call('storage:link');
});
Route::put('/issues-update-user/{id}', 'User\IssuesController@update',function(){
    Artisan::call('storage:link');
});
Route::get('/issues-show-user/{id}', 'User\IssuesController@show',function(){
    Artisan::call('storage:link');
});
Route::get('/dynamic-user/fetch', 'User\IssuesController@fetch')->name('dynamiccontroller.fetch');
Route::get('/findid-user', 'User\IssuesController@findid');
Route::get('/findidother-user', 'User\IssuesController@findidother');
Route::get('/issues-create-user', 'User\IssuesController@create');
Route::post('/issues-store-user', 'User\IssuesController@store')->name('issues-store');

//tracker//
Route::get('/tracker', 'Admin\TrackerController@index');
Route::get('/tracker-create', 'Admin\TrackerController@create');
Route::post('/tracker-store', 'Admin\TrackerController@store');
Route::get('/tracker-edit/{id}', 'Admin\TrackerController@edit');
Route::put('/tracker-update/{id}', 'Admin\TrackerController@update');
Route::delete('/tracker-delete/{id}', 'Admin\TrackerController@delete');
Route::get('/dynamic/fetch', 'Admin\IssuesController@fetch')->name('dynamiccontroller.fetch');


//priority//
Route::get('/priority', 'Admin\PriorityController@index');
Route::get('/priority-create', 'Admin\PriorityController@create');
Route::post('/priority-store', 'Admin\PriorityController@store');
Route::get('/priority-edit/{id}', 'Admin\PriorityController@edit');
Route::put('/priority-update/{id}', 'Admin\PriorityController@update');
Route::delete('/priority-delete/{id}', 'Admin\PriorityController@delete');

//status//
Route::get('/status', 'Admin\StatusController@index');
Route::get('/status-create', 'Admin\StatusController@create');
Route::post('/status-store', 'Admin\StatusController@store');
Route::get('/status-edit/{id}', 'Admin\StatusController@edit');
Route::put('/status-update/{id}', 'Admin\StatusController@update');
Route::delete('/status-delete/{id}', 'Admin\StatusController@delete');

//department//
Route::get('/department', 'Admin\DepartmentController@index');
Route::get('/department-create', 'Admin\DepartmentController@create');
Route::post('/department-store', 'Admin\DepartmentController@store');
Route::get('/department-edit/{id}', 'Admin\DepartmentController@edit');
Route::put('/department-update/{id}', 'Admin\DepartmentController@update');
Route::delete('/department-delete/{id}', 'Admin\DepartmentController@delete');
Route::get('/changStatus', 'Admin\DepartmentController@changStatus')->name('change_Status');


// Route::get('/abouts', 'Admin\AboutusController@index');
// Route::post('/save-aboutus', 'Admin\AboutusController@store');
// Route::put('/aboutus-update/{id}', 'Admin\AboutusController@update');
// Route::get('/about-us/{id}', 'Admin\AboutusController@edit');
// Route::delete('/about-us-delete/{id}', 'Admin\AboutusController@delete');

// Route::get('/category', 'Admin\CategoryController@index');
// Route::post('/category-store', 'Admin\CategoryController@store');
// Route::get('/category-edit/{id}', 'Admin\CategoryController@edit');
// Route::put('/category-update/{id}', 'Admin\CategoryController@update');
// Route::get('/category-create', 'Admin\CategoryController@create');
// Route::delete('/category-delete/{id}', 'Admin\CategoryController@delete');

// Route::get('/category-list', 'Admin\CategorylistController@index');
// Route::get('/category-list-edit/{id}', 'Admin\CategorylistController@edit');
// Route::post('/category-list-add', 'Admin\CategorylistController@store');
// Route::put('/category-list-update/{id}', 'Admin\CategorylistController@update');
// });

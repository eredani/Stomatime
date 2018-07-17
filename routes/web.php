<?php

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

Route::get('/', 'Controller@index')->name('index');
Auth::routes();

Route::prefix('admin')->group(function() 
{
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/','AdminController@index')->name('admin.dashboard');
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});
Route::prefix('cabinet')->group(function() 
{
  Route::post('/setpublicprofile', 'CabinetController@setpublicprofile')->name('cabinet.setpublicprofile');
  Route::post('/editprofile', 'CabinetController@editprofile')->name('cabinet.editprofile');
  Route::post('/edilogo', 'CabinetController@setprofile')->name('cabinet.setprofile');
  Route::get('/setting', 'CabinetController@setting')->name('cabinet.setting');
  Route::get('/login', 'Auth\CabinetLoginController@showLoginForm')->name('cabinet.login');
  Route::get('/register', 'Auth\CabinetRegisterController@index')->name('cabinet.index');
  Route::post('/register', 'Auth\CabinetRegisterController@register')->name('cabinet.register');
  Route::post('/login', 'Auth\CabinetLoginController@login')->name('cabinet.login.submit');
  Route::get('/', 'CabinetController@index')->name('cabinet.dashboard');
  Route::post('/logout', 'Auth\CabinetLoginController@logout')->name('cabinet.logout');
  Route::post('/password/email', 'Auth\CabinetForgotPasswordController@sendResetLinkEmail')->name('cabinet.password.email');
  Route::get('/password/reset', 'Auth\CabinetForgotPasswordController@showLinkRequestForm')->name('cabinet.password.request');
  Route::post('/password/reset', 'Auth\CabinetResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\CabinetResetPasswordController@showResetForm')->name('cabinet.password.reset');

  Route::get('/config', 'CabinetController@config')->name('cabinet.config');
  Route::post('/addspeci', 'CabinetController@addspeci')->name('cabinet.addspeci');
  Route::post('/delspeci', 'CabinetController@delspeci')->name('cabinet.delspeci');

  Route::post('/addserv', 'CabinetController@addserv')->name('cabinet.addserv');
  Route::post('/delserv', 'CabinetController@delserv')->name('cabinet.delserv');

  Route::post('/addsala', 'CabinetController@addsala')->name('cabinet.addsala');
  Route::post('/delsala', 'CabinetController@delsala')->name('cabinet.delsala');

  Route::post('/addmedic', 'CabinetController@addmedic')->name('cabinet.addmedic');

  Route::post('/medicimg', 'CabinetController@medicimg')->name('cabinet.config.profile.medic');
  Route::post('/medicsetsala', 'CabinetController@medicsetsala')->name('cabinet.medic.set.sala');
  Route::post('/medicsetspeci', 'CabinetController@medicsetspeci')->name('cabinet.medic.set.speci');
  Route::post('/medicdelspeci', 'CabinetController@medicdelspeci')->name('cabinet.medic.delspeci');
  Route::post('/medicaddspeci', 'CabinetController@medicaddspeci')->name('cabinet.medic.addspeci');
  
  Route::post('/mediceditprogram', 'CabinetController@mediceditprogram')->name('cabinet.medic.edit.program');
});
Route::prefix('/')->group(function() 
{
Route::post('2fa', function () {return redirect('/home');})->name('2fa')->middleware('2fa');
Route::get('setting', 'HomeController@setting')->name('setting');
Route::post('editprofile', 'HomeController@editprofile')->name('editprofile');
Route::post('setprofile', 'HomeController@setprofile')->name('setprofile');
Route::post('enabletwoauth', 'HomeController@enabletwoauth')->name('enabletwoauth');
Route::post('disabletwoauth', 'HomeController@disabletwoauth')->name('disabletwoauth');
Route::get('verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('vf/{token}', 'Auth\CabinetRegisterController@verify');
Route::get('home/{s?}', 'HomeController@index')->name('view.cabinete');
Route::get('view/{id}', 'HomeController@view')->name('view.cabs');
Route::get('view/{id}/servicii', 'HomeController@viewservicii')->name('view.cabs.serv');
Route::get('view/{id}/medici', 'HomeController@viewmedici')->name('view.cabs.medic');
Route::get('view/{id}/medic/{idm}', 'HomeController@viewmedic')->name('view.cabs.medicprofile');
Route::post('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
});


Route::group(array('prefix' => 'api/', 'before' => 'auth.basic'), function()
{
    Route::get('cabinete/{option?}','API@getcabinete');
});
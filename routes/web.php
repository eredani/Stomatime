<?php

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
  Route::post('/setpublicprofile', 'CabinetController@setPublicProfile')->name('cabinet.setpublicprofile');
  Route::post('/editprofile', 'CabinetController@editProfile')->name('cabinet.editprofile');
  Route::post('/edilogo', 'CabinetController@setProfile')->name('cabinet.setprofile');
  Route::get('/setting', 'CabinetController@setting')->name('cabinet.setting');
  Route::get('/login', 'Auth\CabinetLoginController@showLoginForm')->name('cabinet.login');
  Route::get('/register', 'Auth\CabinetRegisterController@index')->name('cabinet.index');
  Route::post('/register', 'Auth\CabinetRegisterController@register')->name('cabinet.register');
  Route::post('/login', 'Auth\CabinetLoginController@login')->name('cabinet.login.submit');
  Route::get('/','CabinetController@index')->name('cabinet.dashboard');
  Route::post('/logout', 'Auth\CabinetLoginController@logout')->name('cabinet.logout');
  Route::post('/password/email', 'Auth\CabinetForgotPasswordController@sendResetLinkEmail')->name('cabinet.password.email');
  Route::get('/password/reset', 'Auth\CabinetForgotPasswordController@showLinkRequestForm')->name('cabinet.password.request');
  Route::post('/password/reset', 'Auth\CabinetResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\CabinetResetPasswordController@showResetForm')->name('cabinet.password.reset');

  Route::get('/config', 'CabinetController@config')->name('cabinet.config');
  Route::post('/addspeci', 'CabinetController@addSpeci')->name('cabinet.addspeci');
  Route::post('/delspeci', 'CabinetController@delSpeci')->name('cabinet.delspeci');

  Route::post('/addserv', 'CabinetController@addServ')->name('cabinet.addserv');
  Route::post('/delserv', 'CabinetController@delServ')->name('cabinet.delserv');

  Route::post('/addsala', 'CabinetController@addSala')->name('cabinet.addsala');
  Route::post('/delsala', 'CabinetController@delSala')->name('cabinet.delsala');

  Route::post('/addmedic', 'CabinetController@addMedic')->name('cabinet.addmedic');

  Route::post('/medicimg', 'CabinetController@medicImg')->name('cabinet.config.profile.medic');
  Route::post('/medicsetsala', 'CabinetController@medicSetSala')->name('cabinet.medic.set.sala');
  Route::post('/medicsetspeci', 'CabinetController@medicSetSpeci')->name('cabinet.medic.set.speci');
  Route::post('/medicdelspeci', 'CabinetController@medicDelSpeci')->name('cabinet.medic.delspeci');
  Route::post('/medicaddspeci', 'CabinetController@medicAddSpeci')->name('cabinet.medic.addspeci');
  
  Route::post('/mediceditprogram', 'CabinetController@medicEditProgram')->name('cabinet.medic.edit.program');
  Route::get('programari/', 'CabinetController@programari')->name('programari');
  Route::post('confirmare','CabinetController@confirmare');
});
Route::prefix('/')->group(function() 
{
  Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
  Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
  Route::post('2fa', function () {return redirect('/home');})->name('2fa')->middleware('2fa');
  Route::get('setting', 'HomeController@setting')->name('setting');
  Route::post('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
  Route::post('setprofile', 'HomeController@setProfile')->name('setprofile');
  Route::post('editprofile', 'HomeController@editProfile')->name('editprofile');
  Route::post('enabletwoauth', 'HomeController@enableTwoAuth')->name('enabletwoauth');
  Route::post('disabletwoauth', 'HomeController@disableTwoAuth')->name('disabletwoauth');
  Route::get('verifyemail/{token}', 'Auth\RegisterController@verify');
  Route::get('vf/{token}', 'Auth\CabinetRegisterController@verify');
  Route::get('home/', 'HomeController@index')->name('view.cabinete');
  Route::get('programari/{me?}', 'HomeController@programari')->name('programari');
  Route::get('view/{id}', 'HomeController@view')->name('view.cabs');
  Route::get('view/{id}/servicii', 'HomeController@viewServicii')->name('view.cabs.serv');
  Route::get('view/{id}/medic/{idm}', 'HomeController@viewMedic')->name('view.cabs.medicprofile');
  Route::post('users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
  Route::post('sendscore', 'HomeController@setScore')->name('user.setScore');
  Route::post('sendscoremedic', 'HomeController@setScoreMedic')->name('user.setScoreMedic');
  Route::post('programare', 'HomeController@programare');
  Route::post('program','HomeController@getProgram');
  Route::post('confirmare','HomeController@confirmare');
  Route::post('cancel','HomeController@cancel');
});
Route::group(array('prefix' => 'api/', 'before' => 'auth.basic'), function()
{
    Route::get('cabinete/{option?}','API@getCabinete');
    Route::get('specializari/{id}','API@getSpecializari');
    Route::get('medic/{id_cab}/{id_medic}','API@getMedic');
    
});
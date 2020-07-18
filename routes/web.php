<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect('/appointments');
})->middleware('auth');

Auth::routes();


// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {

    ###################Patients#################
    Route::get('patients/create', 'PatientController@create')->name('patients.create');
    Route::post('/patients', 'PatientController@store')->name('patients.store');
    ###################Appointment#######################
    Route::resource('appointments', 'AppointmentController')->only([
        'index', 'store', 'update', 'edit'
    ]);

});

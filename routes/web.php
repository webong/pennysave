<?php
use Illuminate\Notifications\RoutesNotifications;

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

Route::group(['middleware' => 'auth'], function() {

	Route::get('/home', 'HomeController@index');

	Route::get ('/settings','SettingsController@settings');

	// Team Routes
	Route::get('/create-team', 'TeamController@team');
	Route::post('/create-team', 'TeamController@create')->name('team-create');
	Route::get('/teams/{team_id}', 'TeamController@index');

	// Invite Members
	Route::post('/teams/{team_id}/invite-members', 'TeamController@invite')->name('invite-members');
	Route::post('/teams/{team_id}/invite-members-list', 'TeamController@inviteInList')->name('invite-members-list');
	Route::get('/team/{team_id}/invite/{invite_token}', 'TeamController@invite-register');
	
	// Personal Routes
	Route::get('/create-personal', 'PersonalController@personal');
	Route::post('/create-personal', 'PersonalController@create')->name('personal-create');
	Route::get('/personal/{personal_id}', 'PersonalController@index');

	Route::get('/payment', 'PaymentController@index');


});

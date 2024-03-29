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

Route::get('/team/{team_id}/invite/{invite_token}', 'TeamController@invite_register');
Route::get('/tos', 'LegalController@tos');
Route::get('/privacy', 'LegalController@privacy');

Route::group(['middleware' => 'auth'], function() {

	Route::get('/dashboard', 'HomeController@index')->name('main-dashboard');

	Route::get ('/settings','SettingsController@settings');

	// Team Routes
	Route::get('/create-team', 'TeamController@team');
	Route::post('/create-team', 'TeamController@create')->name('team-create');
	Route::get('/teams/invites', 'TeamController@view_invites');
	Route::post('/teams/invites', 'TeamController@invites_response');

	// Payment Routes
	Route::get('/addpayment', 'PaymentController@addpayment');
	Route::post('/addpayment', 'PaymentController@paynow')->name('pay');
	Route::get('/payment/callback', 'PaymentController@handlecallback');
	Route::get('/{team}/payment/cancelled', 'PaymentController@handlecancelled');
	Route::post('/payment/resolve-account-number', 'PaymentController@resolve_account_number');

	Route::group(['prefix' => '/teams/{team_id}'], function () {
		Route::get('/', 'TeamController@index');

		// Payment Route in Team
		Route::post('/save-account-number', 'PaymentController@save_account_number');
		Route::post('/set-payment', 'TeamController@set_payment_now');

		// Team Commencement management
		Route::post('/update-schedule', 'TeamController@update_schedule');
		Route::post('/start-now', 'TeamController@start_now');
		Route::get('/started', 'TeamController@started_redirect');

		// Announcements
		Route::post('/announcements/create', 'AnnouncementController@create');
		Route::post('/announcements/update', 'AnnouncementController@update');
		Route::post('/announcements/{id}/mark-as-seen', 'AnnouncementController@mark_as_seen');

		// Invite Members
		Route::post('invite-members', 'TeamController@invite')->name('invite-members');
		Route::post('invite-members-list', 'TeamController@invite_in_list')->name('invite-members-list');
		
		// Messages Routes
		Route::get('messages', 'MessageController@index');
		Route::get('messages/create/{everyone?}', 'MessageController@create');
		Route::post('messages/create', 'MessageController@send')->name('send-message');
		Route::get('messages/sent', 'MessageController@sent');
		Route::get('messages/draft', 'MessageController@draft');
		Route::get('messages/trash', 'MessageController@trash')->name('messages.trash');
		Route::post('messages/{type}/actions', 'MessageController@deleteMultiple');
		Route::get('messages/restore/{id}', 'MessageController@restore');
		Route::get('messages/reply/{type}/{id}', 'MessageController@reply');
		Route::get('messages/forward/{type}/{id}', 'MessageController@forward');
		Route::get('messages/trash/{type?}/{id}', 'MessageController@delete');
		Route::get('messages/{type}/{id}', 'MessageController@read');
	});

	// Personal Routes
	Route::get('/create-personal', 'PersonalController@personal');
	Route::post('/create-personal', 'PersonalController@create')->name('personal-create');
	Route::get('/personal/{personal_id}', 'PersonalController@index');

	Route::get('/payment', 'PaymentController@index');


});

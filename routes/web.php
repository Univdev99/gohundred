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


Auth::routes(['verify' => true]);

Route::get('/', function () {
  return view('welcome');
});


Route::get('/redirect/{service}', 'SocialAuthController@redirect');

Route::get('/callback/{service}', 'SocialAuthController@callback');


// Route::get('/mailverification', function () {
//   return view('mailverification');
// });

Route::get('/terms-of-service', function () {
  return view('term of service');
});

Route::get('/privacy_policy', function () {
  return view('privacy_policy');
});

Route::post('stripe/notify', 'StripeController@notify')->name('stripe.notify');

Route::middleware('auth')->group(function () {

  Route::get('/step', 'HomeController@step')->name('step');

  Route::get('/faq', function () {
    return view('FAQ');
  });

  Route::get('/home', 'HomeController@index')->name('home');

  Route::get('/admindashboard', 'HomeController@adminboard')->name('adminboard');

  Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

  Route::post('/dashboard', 'HomeController@addKeyword')->name('stepResult');

  Route::get('/dashboard/{keyword_id}', 'HomeController@showCampaignPage')->name('campaignPage');

  Route::get('/tdata', 'HomeController@getTableData')->name('searchTableData');

  Route::get('/graph', 'HomeController@getGraphData')->name('graphData');

  Route::get('/deleteRow', 'HomeController@deleteRowTabledata');

  Route::get('/adminTable', 'HomeController@getAdminTableData')->name('adminTableData');

  Route::get('/deleteAdminRow', 'HomeController@deleteAdminRowTabledata');

  Route::post('/saveAdminComment', 'HomeController@saveAdminCommentChanges')->name('saveAdminComment');

  Route::post('/job', 'HomeController@getJobStatus')->name('jobStatus');
  Route::post('/saveNewcomments', 'HomeController@saveNewcomments')->name('saveNewcomments');

  Route::get('/plan', 'PlanController@show')->name('plans.show');
  Route::get('/plan/{plan}', 'PlanController@creditCardPay')->name('plans.creditCard');
  Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');

  Route::get('/trial', 'SubscriptionController@trial')->name('trial');

  Route::get('transactions', 'TransactionController@index')->name('transactions');


  Route::get('/slack', 'HomeController@getSlackWebHookURL')->name('slackWebHook');
  Route::post('/addSlack','HomeController@addToSlack')->name('addSlack');


  Route::match(['get', 'post'], '/botman', 'BotManController@handle');

  Route::get('export', 'ExcelExportController@export')->name('excelExport');
  Route::get('admin/export', 'ExcelExportController@adminExport')->name('adminExcelExport');


  // Route::get('/twitter', 'HomeController@search_twitter');

  Route::get('/facebook', 'HomeController@facebook');

//   Route::get('/tiktok', 'HomeController@tiktokApi');

  // Route::get('/youtube', 'HomeController@search_youtube');

  // Route::get('/web', 'HomeController@search_web');

  Route::get('/phpinfo', 'HomeController@phpinfo');

});


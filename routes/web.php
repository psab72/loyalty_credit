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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

    //

Route::middleware(['auth', 'page_permissions'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard-admin', 'DashboardController@admin')->name('dashboard-admin');
    Route::get('/dashboard-agent', 'DashboardController@agent')->name('dashboard-agent');
    Route::get('/dashboard-merchant', 'MerchantController@index')->name('dashboard-merchant');
    Route::get('/loan-requests', 'CreditRequestController@loanRequests')->name('loan-requests');
    Route::get('/credit-request', 'CreditRequestController@index')->name('credit-request')->middleware('check_if_kyc_verified');
    Route::get('/kyc', 'KycController@index')->name('kyc');
    Route::post('/upload-kyc', 'KycController@uploadKycDocuments')->name('upload-kyc');
    Route::post('/credit-request', 'CreditRequestController@postLoanRequest')->name('credit-request');

    Route::get('/dashboard-merchants', 'UserController@index');
    Route::get('/merchant/{id}', 'MerchantController@view')->name('merchant/{id}');
    Route::get('/edit-merchant/{id}', 'MerchantController@edit')->name('edit-merchant/{id}');
    Route::post('/update-merchant', 'MerchantController@update')->name('update-merchant');

    Route::get('/sales-data', 'AjaxController@salesDataPerMonth');
    Route::get('/kyc-data', 'AjaxController@kycData');

    Route::post('/update-kyc', 'AjaxController@updateKyc');
    Route::post('/kyc-assign', 'AjaxController@kycAssign');
    Route::post('/update-loan-request', 'CreditRequestController@updateLoanRequest')->name('update-loan-request');
    Route::post('/pay', 'AjaxController@pay')->name('pay');
    Route::post('/update-current-loan', 'AjaxController@updateCurrentLoan')->name('update-current-loan');
    Route::get('/notification', 'NotificationController@index')->name('notification');
    Route::post('/update-mobile-number', 'AjaxController@updateMobileNumber')->name('update-mobile-number');
    Route::post('/read-notifs', 'AjaxController@readNotifs')->name('read-notifs');



    Route::get('/compute-amortization', 'AjaxController@computeAmortization');
    Route::get('/users', 'UserController@users');
    Route::get('/user/{id}', 'UserController@user');
    Route::post('/update-user', 'UserController@update')->name('update-user');

    Route::post('/update-available-credit', 'AjaxController@updateAvailableCredit')->name('update-available-credit');
    Route::post('/update-payment', 'MerchantController@updatePayment')->name('update-payment');
});
Route::post('/step-one-register', 'AjaxController@stepOneRegister')->name('step-one-register');
Route::post('/step-two-register', 'AjaxController@stepTwoRegister')->name('step-two-register');
Route::post('/step-three-register', 'AjaxController@stepThreeRegister')->name('step-three-register');
Route::post('/step-four-register', 'AjaxController@stepFourRegister')->name('step-four-register');
Route::post('/step-five-register', 'AjaxController@stepFiveRegister')->name('step-five-register');
Route::post('/step-six-register', 'AjaxController@stepSixRegister')->name('step-six-register');
Route::post('/login-user', 'AjaxController@loginUser')->name('step-six-register');
Route::get('/cities', 'AjaxController@getCities')->name('cities');
Route::get('/barangays', 'AjaxController@getBarangays')->name('barangays');

//Route::get('/test-email', function() {
//    $to_name = 'TO_NAME';
//    $to_email = 'test1987@yopmail.com';
//    $data = array('name'=>"Philip", "body" => "Test mail");
//
//    Mail::send('emails.test', $data, function($message) use ($to_name, $to_email) {
//        $message->to($to_email, $to_name)
//            ->subject('Artisans Web Testing Mail');
//        $message->from('support@loyaltycredit','Artisans Web');
//    });
//});

//Route::get('/test', function() {
//    \App\User::insert([
//        'first_name' => 'Admin 1',
//        'middle_name' => 'Admin 1',
//        'last_name' => 'Admin 1',
//        'email' => 'admin1@yopmail.com',
//        'password' => \Illuminate\Support\Facades\Hash::make('123456')
//    ]);
//});
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

Route::get('/', 'PagesController@index');
Route::get('/index', 'PagesController@index');
Route::get('/mobileIndex', 'PagesController@mobileIndex');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
Route::get('/copyright', 'PagesController@copyright');
Route::get('/dmca', 'PagesController@dmca');
Route::get('/faq', 'PagesController@faq');
Route::get('/register', 'PagesController@register');
Route::get('/terms', 'PagesController@terms');

//========================
// BITCOIN GATEWAYCALLBACK
//========================
Route::post('/payment/cryptobox-callback', 'CryptoController@PaymentCallback');
Route::get('/sample', 'CryptoController@Sample');


Route::get('/unauthorized', function($request, $guard = null)
{
    if (Auth::guard('company')->check()) {
        return redirect('/company');
    }
    elseif (Auth::guard('admin')->check()) {
        return redirect('/admin');
    }
    elseif (Auth::guard('user')->check()) {
        return redirect('/user');
    }
    else
    {
        return redirect('/');
    }
})->name('ReturnToUnauthorizedPage');


Route::namespace('Auth')->group(function(){

    /* Reset Password Routes */
    //For checking out multi-Auth Password reset : https://ysk-override.com/Multi-Auth-in-laravel-54-Reset-Password-20170205/
    Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

    Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');




    /* Verification Routes */
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::get('email/resend/{role}/{email}', 'VerificationController@resend')->name('verification.resend');

    /*LOGIN / Regsiter  Routes */
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@LoginLogic');

    Route::post('/register', 'RegisterController@RegisterLogic');
    Route::get('/register', 'RegisterController@showRegisterForm');

    
    Route::get('/login/admin', 'LoginController@showLoginFormAdmin');

    Route::post('/register/admin', 'RegisterController@RegisterLogicAdmin');
    Route::get('/register/admin', 'RegisterController@showRegisterFormAdmin');

    /*LOGOUT  Routes */
    Route::post('/logout','LoginController@logout');
});


/*Only Company can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:company','verified']], function () {
    Route::get('/company', 'CompanyController@Dashboard');
    Route::post('/company','CompanyController@ManageAdmin')->name('ManageAdmin');

    Route::post('/company/{adminId}/IdleUser','CompanyController@IdleUser');
    Route::post('/company/{adminId}/deleteUser','CompanyController@DeleteUser');

    Route::get('/company/ViewIdleUsers', 'CompanyController@ViewIdleUsers');
    Route::post('/company/deleteIdleUser', 'CompanyController@DeleteIdleUsers');


    Route::get('/company/{adminId}', 'CompanyController@AdminView');
    Route::post('/company/{adminId}', 'CompanyController@UserUpload')->name('UserUpload');

    Route::get( '/download/{filename}', 'CompanyController@download');
});

Route::get('/principal', function(){
    return "Go to Principal for some reason";
});


/*Only Company can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:admin','verified']], function () {
    Route::get('/admin', 'AdminController@Dashboard');
    
    Route::get('/admin/accounts', 'AdminController@Accounts');
    Route::post('/admin/accounts', 'AdminController@ManageAccountsUpload')->name('ManageAccountsUpload');

    Route::get('/admin/fullz', 'AdminController@fullz');
    Route::post('/admin/fullz', 'AdminController@ManagefullzUpload')->name('ManagefullzUpload');


    Route::get('/admin/banks', 'AdminController@Banks');
    Route::post('/admin/banks', 'AdminController@ManageBanksUpload')->name('ManageBanksUpload');


    Route::get('/admin/rules', 'AdminController@Rules');
    Route::get('/admin/users', 'AdminController@Users');

    Route::post('/admin/block-user', 'AdminController@BlockUser');
    Route::post('/admin/unblock-user', 'AdminController@UnBlockUser');
});


/*Only User can use it. any authorized/unauthorized person that uses it will be redirected to Authenticate.php Middleware
and it will return it to the ReturnToUnauthorizedPage route and that will redirect it accoring to it's gurad */
Route::group(['middleware' => ['auth:user','verified']], function () {
    
    Route::get('/user', 'UserController@Dashboard');
    
    Route::get('/user/accounts/paypal', 'UserController@AccountsPaypal');
    Route::post('/user/accounts', 'UserController@buyAccounts');




    Route::get('/user/fullz/My3', 'UserController@fullzMy3');
    Route::get('/user/fullz/O2', 'UserController@fullzO2');
    Route::get('/user/fullz/EE', 'UserController@fullzEE');
    Route::get('/user/fullz/HMRC', 'UserController@fullzHMRC');
    Route::post('/user/fullz', 'UserController@buyFullz');
    Route::post('/user/fullz/{fullzType}', 'UserController@FullzBinSearch');
    



    Route::get('/user/banks', 'UserController@Banks');
    Route::post('/user/banks', 'UserController@BanksBinSearch');
    Route::post('/user/banks/buy', 'UserController@buyBanks');


    Route::get('/user/mypurchases', 'UserController@myPurchases');
    
    
    Route::get('/user/myaccount', 'UserController@MyAccount');
    Route::post('/user/myaccount', 'UserController@ManageMyAccount');

    Route::get('/user/rules', 'UserController@Rules');
    Route::get('/user/addfunds', 'UserController@ViewAddFunds');
    Route::post('/user/addfunds', 'UserController@ViewAddFunds')->name('addFunds');
    
    Route::get('/user/newticket', 'UserController@NewTicket');
    Route::post('/user/newticket', 'UserController@NewTicketSubmit');

    
    
});




//used to delete the cache stored when redirect with data from some function.
header('Cache-Control: no-store, private, no-cache, must-revalidate'); header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Expires: 0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header ('Pragma: no-cache');

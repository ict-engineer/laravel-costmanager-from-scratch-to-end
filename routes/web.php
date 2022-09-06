<?php

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
Route::get('/', 'HomeController@index');
Route::get('/public_quote/{id}', 'Client\PublicQuoteController@index');

Auth::routes(['verify' => true]);

Route::get('/api_docs', function() {
    return view('user.api_docs.index');
});

Route::post('stripe/webhook', 'WebhookController@handleWebhook');
Route::get('/changeLang', 'LangController@changeLang')->name('changeLang');
Route::get('/showTerms', 'Auth\TermController@showTerm')->name('showTerms');
Route::get('/showConditions', 'Auth\TermController@showCondition')->name('showConditions');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::get('auth/facebook', 'Auth\FacebookController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\FacebookController@handleFacebookCallback');

// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth', 'verified']], function() {

    Route::get('/welcome', 'User\DashboardController@index')->name('welcome');
    Route::post('/setClientLocation', 'User\DashboardController@setLatLng')->name('setClientLocation');
    Route::post('/getClientDashboardInfo', 'User\DashboardController@getClientDashboardInfo')->name('getClientDashboardInfo');
    Route::post('/getGraphInfo', 'User\DashboardController@getGraphInfo')->name('getGraphInfo');
    Route::post('/setSessionValue', 'User\DashboardController@setSessionValue')->name('setSessionValue');
    Route::get('/setprovider', function(){
        return view('auth.setprovider');
    })->name('setprovider');
    Route::get('/setclient', function(){
        return view('auth.setclient');
    })->name('setclient');
    Route::get('/setpurchase', 'User\SelectTypeController@showPurchase')->name('setpurchase');
    Route::post('/stripepost', 'User\SelectTypeController@postStripe')->name('stripepost');
    Route::post('/crop-image-upload', 'User\ProfileController@uploadImage')->name('crop-image-upload');
    Route::post('/crop-logo-image-upload', 'User\ProfileController@uploadLogoImage')->name('crop-logo-image-upload');
    
    Route::post('/user/useruploadDataFile', 'User\MaterialController@uploadDataFile')->name('useruploadDataFile');
    Route::post('/user/userstoreDataFile', 'User\MaterialController@storeDataFile')->name('userstoreDataFile');
    Route::post('/user/addMaterial', 'User\MaterialController@addMaterial')->name('addMaterial');

});

Route::group(['middleware' => ['can:Access Admin'], 'middleware' => ['auth', 'verified']], function() {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    });
    Route::resource('roles','RoleController');
    Route::resource('usersetup','Admin\UserController');
    Route::resource('services','Admin\ServiceController');
    Route::resource('providers','Admin\ProviderController');
    Route::resource('shops', 'Admin\ShopController');
    Route::resource('terms', 'Admin\TermController');
    Route::resource('materials', 'Admin\MaterialController');
    Route::get('shoplist', 'Admin\MaterialController@getShopList')->name('shoplist');
    Route::post('uploadDataFile', 'Admin\MaterialController@uploadDataFile')->name('uploadDataFile');
    Route::post('storeDataFile', 'Admin\MaterialController@storeDataFile')->name('storeDataFile');
    Route::resource('payments', 'Admin\PaymentController');
    
    Route::resource('clients','Admin\ClientController');
    Route::resource('smtp','Admin\SmtpController');
    Route::resource('promocode','Admin\PromocodeController');
});



Route::get('servicepaymentlist', 'User\ProfileController@getServicePaymentList')->name('servicepaymentlist');

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function() {
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/profile/saveGeneral', 'ProfileController@saveUserInfo')->name('profile.saveGeneral');
    Route::post('/profile/saveProvider', 'ProfileController@saveProvider')->name('profile.saveProvider');
    Route::post('/profile/saveClient', 'ProfileController@saveClient')->name('profile.saveClient');
    Route::post('/profile/savePassword', 'ProfileController@savePassword')->name('profile.savePassword');
    Route::get('/profile/provider', function() {
        return view('user.profile.provider');
    })->name('profile.provider');
    Route::get('/profile/client', function() {
        return view('user.profile.client');
    })->name('profile.client');
    Route::post('/getMaterialbyName', 'MaterialController@getMaterialbyName')->name('getMaterialbyName');
    Route::get('/getAllShops', 'MaterialController@getAllShops')->name('getAllShops');
});


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function() {
    Route::get('selectType', 'SelectTypeController@index')->name('selectType');
    Route::post('setUserType', 'SelectTypeController@setUserType')->name('setUserType');
    
    Route::post('setProviderInfo', 'SelectTypeController@setProvider')->name('setProviderInfo');
    Route::post('setClientInfo', 'SelectTypeController@setClient')->name('setClientInfo');
    Route::resource('providershops','ShopController');
    Route::resource('providermaterials','MaterialController');

    Route::get('payments', 'PaymentController@index')->name('payments');
    Route::post('setPayment', 'PaymentController@setPayment')->name('setPayment');
});

Route::group(['middleware' => ['auth', 'verified', 'subscribed'], 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'Client'], function() {
    Route::resource('clientemployees','EmployeeController');
    Route::post('sendinvite','EmployeeController@sendInvite')->name('sendinvite');
    Route::post('employeeimage', 'EmployeeController@uploadImage')->name('employeeimage');
    Route::resource('clientexpensetypes','ExpenseTypeController');
    Route::resource('clientfixedexpenses','FixedExpenseController');
    Route::resource('clientservices','CServiceController');
    Route::resource('clientclients','CClientController');
    Route::resource('clientquotes','CQuoteController');
    Route::post('getQuoteInfo', 'CQuoteController@getQuoteInfo')->name('getQuoteInfo');
    Route::post('updateQuoteStatus', 'CQuoteController@updateQuoteStatus')->name('updateQuoteStatus');
    Route::get('getFixedExpenseSum', 'CQuoteController@getFixedExpenseSum')->name('getFixedExpenseSum');
    Route::post('saveQuoteComment', 'CQuoteController@saveQuoteComment')->name('saveQuoteComment');
    Route::post('sendByMail', 'CQuoteController@sendByMail')->name('sendByMail');
    Route::post('sendByWhatsapp', 'CQuoteController@sendByWhatsapp')->name('sendByWhatsapp');
    Route::get('getallcservices', 'CQuoteController@getAllCServices')->name('getallcservices');
    Route::get('/generateInvoice/{id}', 'CQuoteController@generateInvoice')->name('generateInvoice');
    Route::post('/duplicateQuote', 'CQuoteController@duplicateQuote')->name('duplicateQuote');
    Route::post('/getDuplicateId', 'CQuoteController@getDuplicateId')->name('getDuplicateId');

    Route::resource('clientinvoices','CInvoiceController');
    Route::post('updateInvoiceStatus', 'CInvoiceController@updateInvoiceStatus')->name('updateInvoiceStatus');
    Route::resource('consult_materials','ConsultMaterialController');
    Route::resource('clientprojects','ProjectController');
    Route::resource('clientmaterials','CMaterialController');
    Route::get('getallexpensetypes', 'ExpenseTypeController@getAll')->name('getallexpensetypes');
    Route::get('getallcclients', 'CClientController@getAll')->name('getallcclients');
    Route::post('getcclientinfobyname', 'CClientController@getClientInfobyName')->name('getcclientinfobyname');
    Route::post('getclientprojects', 'ProjectController@getProjectInfo')->name('getclientprojects');
    Route::get('purchaseplan', 'PurchaseController@index')->name('purchaseplan');
    Route::post('setpurchaseplan', 'PurchaseController@setPlan')->name('setpurchaseplan');
    Route::get('cancelPurchaseplan', 'PurchaseController@cancelPurchaseplan')->name('cancelPurchaseplan');

    Route::post('clientuploadDataFile', 'CMaterialController@uploadDataFile')->name('clientuploadDataFile');
    Route::post('clientstoreDataFile', 'CMaterialController@storeDataFile')->name('clientstoreDataFile');
    Route::post('addCMaterial', 'CMaterialController@addCMaterial')->name('addCMaterial');
    Route::get('getCMaterials', 'CMaterialController@getCMaterials')->name('getCMaterials');
    Route::get('getConsultMaterials', 'ConsultMaterialController@getConsultMaterials')->name('getConsultMaterials');
});
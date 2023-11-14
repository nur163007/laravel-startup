<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\BkashTokenizePaymentController;


Route::group(['middleware'=>'api'],function($router){
    Route::get('/registration',[RegistrationController::class, 'showRegisterFrom']);
    Route::get('/countries',[CountryController::class,'getCountry'])->name('country');
    Route::get('/terms',[RegistrationController::class,'getTerms']);
//    Route::post('/register',[RegistrationController::class,'register']);
//    Route::get('/verify',[RegistrationController::class,'verifyEmail']);
    Route::get('/',[RegistrationController::class,'loginForm']);
//    Route::post('/loginCheck',[RegistrationController::class,'login'])->name('logincheck');
    Route::post('/logout',[RegistrationController::class,'logout'])->name('user_logout');

    //      Dashboard route
    Route::get('/dashboard',[DashboardController::class,'index']);

    //      Sidebar route
    Route::get('get/sidebar/{role}',[ModuleController::class,'sidebar'])->name('get.sidebar');

    //      Navigation route
    Route::get('/navigation',[ModuleController::class,'viewNavigation'])->name('view.navigation');
    Route::get('/parent',[ModuleController::class,'parentNav'])->name('parent');
    Route::post('/add-navigation',[ModuleController::class,'addNavigation'])->name('add.navigation');
    Route::get('/show-navigation',[ModuleController::class,'allNavigation'])->name('all.navigation');
    Route::get('/navigation-edit/{id}',[ModuleController::class,'editNavigation']);
    Route::delete('/navigation-delete/{id}',[ModuleController::class,'deleteNavigation']);

    //      User route
    Route::get('/users',[UserController::class,'userIndex'])->name('view.user');
    Route::get('/all-users',[UserController::class,'userData'])->name('view.alluser');
    Route::get('/role',[UserController::class,'getRole'])->name('role');
    Route::post('/add-user',[UserController::class,'userStore'])->name('user.store');
    Route::get('/user-edit/{id}',[UserController::class,'editUser']);
    Route::delete('/user-delete/{id}',[UserController::class,'deleteUser']);

    //      Role route
    Route::get('/roles',[UserController::class,'roleIndex'])->name('view.role');
    Route::get('/all-roles',[UserController::class,'roleData'])->name('all.role');
    Route::post('/add-role',[UserController::class,'roleStore'])->name('role.store');
    Route::get('/role-edit/{id}',[UserController::class,'editRole']);
    Route::delete('/role-delete/{id}',[UserController::class,'deleteRole']);

    // lookup route
    Route::get('/lookup',[ModuleController::class,'lookupIndex'])->name('view.lookup');
    Route::post('/add-lookup',[ModuleController::class,'addLookup'])->name('add.lookup');
    Route::get('/show-lookup',[ModuleController::class,'allLookup'])->name('all.lookup');
    Route::get('/show-lookup-parent',[ModuleController::class,'getLookupParent'])->name('lookup.parent');
    Route::get('/lookup-edit/{id}',[ModuleController::class,'editLookup']);
    Route::delete('/lookup-delete/{id}',[ModuleController::class,'deleteLookup']);

    // Profile route
    Route::get('/user/profile',[UserController::class,'getProfile'])->name('user.profile');
    Route::get('/user/edit/profile',[UserController::class,'getEditProfile'])->name('user.editProfile');
    Route::post('/user/profile/change/password',[UserController::class,'getChangePassword'])->name('change.password');
    Route::post('/user/profile/change/data',[UserController::class,'getChangeProfileData'])->name('change.user.data');
    Route::post('/user/profile/image/change',[UserController::class,'getChangeProfileImage'])->name('change.profile.image');
    Route::post('/user/profile/nid/change',[UserController::class,'getChangeNID'])->name('change.profile.nid');
    Route::get('/user/profile/nid/show/{id}',[UserController::class,'getNIDdata'])->name('show.nid');

    // dashboard route
    Route::get('/show/dashboard/data',[ModuleController::class,'allUserRequest'])->name('all.dashboard.data');
    Route::get('/user/profile/info/{id}',[ModuleController::class,'showUserProfile'])->name('user.profile.page');
    Route::get('/individual-users-profile/{id}',[ModuleController::class,'individualProfile'])->name('ind.profile.data');
    Route::get('/user/accept/data/{id}',[ModuleController::class,'userAcceptFn'])->name('user.profile.accept');
    Route::post('/user/reject/data/',[ModuleController::class,'userRejectFn'])->name('user.rejection.data');
    Route::get('/user/pos/dashboard/list/{userid}',[ModuleController::class,'posDashboardInfo'])->name('user.pos.dashboard');
    Route::get('/user/pos/complete/payment/{userid}',[ModuleController::class,'posCompletePayment'])->name('user.pos.complete.list');
    Route::get('/user/partner/count/users/{userid}',[ModuleController::class,'countUsers'])->name('user.partner.count');


    // Admin privilege route
    Route::get('/privilege',[ModuleController::class,'privilegeIndex'])->name('view.privilege');
    Route::get('show/privilege',[ModuleController::class,'showPrivilegeData'])->name('show.privilege');
    Route::get('update/privilege',[ModuleController::class,'updatePrivilegeData'])->name('privilege.update');

    // CONTENT CREATE ROUTE

    Route::get('create-content',[ContentController::class,'create']);
    Route::get('get/content-type',[ContentController::class,'getContentType'])->name('contenttype.lookup');
    Route::post('add-content',[ContentController::class,'store'])->name('add.content');
    Route::get('view-content',[ContentController::class,'index']);
    Route::get('show-all-content',[ContentController::class,'show'])->name('show.all.content');

});


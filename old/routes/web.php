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

/*======================================
=            Theme Routes            =
======================================*/
Auth::routes();

Route::get('/cache',function(){
\Artisan::call('config:clear');
\Artisan::call('cache:clear');
\Artisan::call('view:clear');
dd('cleared');
});

Route::get('/', 'ThemeController@index')->name('theme.index');
Route::get('/home', 'ThemeController@index')->name('theme.home');
Route::get('/resources','ThemeController@resources')->name('theme.resources');
Route::get('/resources/category/{category}','ThemeController@resourcesByCategory')->name('theme.resourcesbycategory');
Route::get('/resource/{resource}','ThemeController@singleResource')->name('theme.singleresource');
Route::post('/resource/review','ThemeController@addReviewToResource')->name('theme.addreviewtoresource')->middleware('auth');
Route::post('/resource/review/{review}/update','ThemeController@updateReviewFromResource')->name('theme.updatereviewfromresource')->middleware('auth');
Route::get('/resource/review/{review}/delete','ThemeController@deleteReviewFromResource')->name('theme.deletereviewfromresource')->middleware('auth');
Route::post('/resource/flag','ThemeController@flagResource')->name('theme.flagresource')->middleware('auth');
Route::get('/resources/filtered','ThemeController@filteredResources')->name('theme.resources.filtered');
Route::get('/support-us','ThemeController@supportUs')->name('theme.supportus');
Route::post('/support-us/donate','ThemeController@supportUsDonationOneTime')->name('theme.supportus.donationonetime');
Route::get('/resources/saved','ThemeController@savedResources')->name('theme.savedresources')->middleware('auth');
Route::get('/resource/{resource}/save','ThemeController@saveResource')->name('theme.saveresource')->middleware('auth');
Route::get('/resource/{resource}/unsave','ThemeController@unSaveResource')->name('theme.unsaveresource')->middleware('auth');
Route::get('/resource/{resource}/like','ThemeController@likeResource')->name('theme.likeresource')->middleware('auth');
Route::get('/resource/{resource}/download','ThemeController@downloadResource')->name('theme.downloadresource')->middleware('auth');
Route::get('/contactus','ThemeController@contactus')->name('theme.contactus');
Route::post('/contactus/sendmail','ThemeController@sendContactMail')->name('theme.contactus.sendmail');
Route::post('/newsletter/subscribe','ThemeController@newsletterSubscription')->name('theme.newslettersubscription');

/*=====  End of Generic Routes  ======*/

Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::prefix('dashboard')->group(function(){
	Route::get('/messages','MessageController@index')->name('dashboard.messages.index');
	Route::post('/messages/chathistory','MessageController@getChatHistory')->name('dashboard.messages.getchathistory');
	Route::post('/message/send','MessageController@sendMessage')->name('dashboard.messages.send');
	Route::post('/statistics','DashboardController@getStatistics')->name('dashboard.statistics.ajax');
	Route::get('/password','DashboardController@password')->name('dashboard.password');
	Route::post('/password/update','DashboardController@updatePassword')->name('dashboard.password.update');
	Route::prefix('/resources')->group(function(){
			Route::get('/','ResourceController@userResources')->name('dashboard.resources.user');
			Route::get('/{resource}/preview','ResourceController@previewUserResource')->name('dashboard.resources.preview.user');
			Route::get('/upload','ResourceController@upload')->name('dashboard.resources.upload');
			Route::post('/process-upload','ResourceController@processUpload')->name('dashboard.resources.processupload');
			Route::get('/{resource}/edit','ResourceController@edit')->name('dashboard.resources.edit');
			Route::post('/{resource}/update','ResourceController@update')->name('dashboard.resources.update');
			Route::get('/submit-for-review/{resource}','ResourceController@submitDraftedForReview')->name('dashboard.resource.submitforreviewbyuser');
			// Ajax Route
			Route::post('/process-resource-attachment','ResourceController@processResourceAttachment')->name('ajax.resource.attachment.process');
		});

	/*----------  Routes for  Admin Role  ----------*/
	
	Route::prefix('admin')->group(function(){
		Route::get('/donations','DashboardController@donations')->name('dashboard.donations');
		Route::prefix('resources')->group(function(){
			Route::get('/','ResourceController@index')->name('dashboard.resources.index');
			Route::get('/approve/{resource}','ResourceController@approve')->name('dashboard.resources.approve');
			Route::post('/disapprove/{resource}','ResourceController@disapprove')->name('dashboard.resources.disapprove');
			Route::get('/destroy/{resource}','ResourceController@destroy')->name('dashboard.resources.destroy');
			Route::get('/flagged','ResourceController@flaggedResources')->name('dashboard.resources.flagged');
			Route::get('/flag/{flag}/reject','ResourceController@rejectFlag')->name('dashboard.resource.flagreject');
			Route::post('/featured','ResourceController@featured')->name('dashboard.resources.featured'); // Ajax

			Route::prefix('categories')->group(function(){
				Route::get('/','ResourceCategoryController@index')->name('dashboard.resources.categories.index');
				Route::post('/store','ResourceCategoryController@store')->name('dashboard.resources.categories.store');
				Route::get('/edit/{category}','ResourceCategoryController@edit')->name('dashboard.resources.categories.edit');
				Route::post('/update/{category}','ResourceCategoryController@update')->name('dashboard.resources.categories.update');
				Route::get('/destroy/{category}','ResourceCategoryController@destroy')->name('dashboard.resources.categories.destroy');
			});
			Route::prefix('tags')->group(function(){
				Route::get('/','ResourceTagController@index')->name('dashboard.resources.tags.index');
				Route::get('/create','ResourceTagController@create')->name('dashboard.resources.tags.create');
				Route::post('/store','ResourceTagController@store')->name('dashboard.resources.tags.store');
				Route::get('/edit/{tag}','ResourceTagController@edit')->name('dashboard.resources.tags.edit');
				Route::post('/update/{tag}','ResourceTagController@update')->name('dashboard.resources.tags.update');
				Route::get('/destroy/{tag}','ResourceTagController@destroy')->name('dashboard.resources.tags.destroy');
			});
		});
		Route::prefix('users')->group(function(){
			Route::get('/','UserController@index')->name('dashboard.users.index');
			Route::get('/create','UserController@create')->name('dashboard.users.create');
			Route::post('/store','UserController@store')->name('dashboard.users.store');
			Route::get('/edit/{user}','UserController@edit')->name('dashboard.users.edit');
			Route::post('update/{user}','UserController@update')->name('dashboard.users.update');
			Route::get('/block/{user}','UserController@block')->name('dashboard.users.block');
			Route::get('/activate/{user}','UserController@activate')->name('dashboard.users.activate');
			Route::get('/destroy/{user}','UserController@destroy')->name('dashboard.users.destroy');
			Route::post('/verified','UserController@verified')->name('dashboard.users.verified.ajax');
		});
		Route::prefix('subscribers')->group(function(){
			Route::get('/','DashboardController@subscribers')->name('dashboard.subscribers');
		});
	});

	/*----------  Routes for  Admin Role  ----------*/

	Route::prefix('user')->group(function(){
		Route::prefix('/profile')->group(function(){
			Route::get('/','UserController@profile')->name('dashboard.user.profile');
			Route::post('/update','UserController@updateProfile')->name('dashboard.user.profile.update');
			Route::post('/update-profile-picture','UserController@updateProfilePicture')->name('dashboard.user.profilepicture.update');
		});
	});

});


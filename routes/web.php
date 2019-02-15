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
Route::group(['namespace'=>'User'],function(){
	Route::get('/','PagesController@index')->name('index');
	Route::get('softwares','PagesController@softwares')->name('softwares');
	Route::get('how_to','PagesController@how_to')->name('how_to');
	Route::get('books','PagesController@books')->name('books');
	Route::get('search','SearchController@result')->name('search');
	//Route::get('search/{query?}','SearchController@result')->name('search.result');
	Route::get('faq','PagesController@faq')->name('faq');

	Route::get('contact','ContactsController@index')->name('contact');
	Route::post('saveContactSubmission','ContactsController@save')->name('saveContactSubmission');



	Route::get('/departments','NavigationsController@departments')->name('departments');
	Route::get('/departments/{dept}/{level_term?}/{course?}','NavigationsController@navUrl')->name('singleDept')->middleware('checkdept');
	Route::post('/email_available/', 'EmailAvailable@check')->name('email_available.check');
	Route::post('/getPostData/', 'EmailAvailable@getSearchData')->name('getSearchData');
	Route::post('/customPasswordChange/', 'EmailAvailable@customPasswordChange')->name('customPasswordChange');
	Route::post('/activitySave/','EmailAvailable@save')->name('activitySave');

	Route::get('trending','PagesController@trending')->name('trending');
});


Route::group(['namespace'=>'Admin'],function(){
	
	Route::get('/admin','HomeController@index')->name('admin.home');
	Route::get('/admin/home','HomeController@index')->name('admin.home');

	Route::resource('admin/departments','DepartmentsController');
	Route::resource('admin/levelterms','LevelTermsController');

	Route::resource('admin/courses','CoursesController');
	Route::post('admin/courses/getlevelterm','CoursesController@getLevelTerm')->name('getlevelterm');
	Route::post('admin/courses/getleveltermbyslug','CoursesController@getLevelTermBySlug')->name('getleveltermbyslug');
	Route::post('admin/courses/getLevelTermDataOnly','CoursesController@getLevelTermDataOnly')->name('getLevelTermDataOnly');
	Route::post('admin/courses/getCourses','CoursesController@getCourses')->name('getCourses');
	Route::get('admin/ajaxcoursedata','CoursesController@listdata')->name('courses.listdata');

	Route::resource('admin/posts','PostsController');
	Route::post('admin/posts/getPostById','PostsController@getPostById')->name('getPostById');
	Route::get('admin/ajaxpostdata','PostsController@listdata')->name('posts.listdata');
	
	Route::resource('admin/userdata','UserDataController');
	Route::delete('admin/userdata/truncate','UserDataController@truncate')->name('userdata.truncate');
	Route::get('admin/ajaxuserdata','UserDataController@listdata')->name('userdata.listdata');

	Route::resource('admin/admins','AdminsController');
	Route::get('admin/profile','AdminsController@profile')->name('admin.profile');
	Route::post('admin/profile','AdminsController@profileUpdate')->name('admin.profileUpdate');
	Route::post('admin/customPasswordChange','AdminsController@customPasswordChange')->name('admin.customPasswordChange');
	Route::resource('admin/roles','RolesController');
	Route::resource('admin/permissions','PermissionsController');

	Route::resource('admin/softwares','SoftwaresController');
	Route::post('admin/posts/getSoftwareById','SoftwaresController@getSoftwareById')->name('getSoftwareById');
	Route::get('admin/ajaxsoftwaredata','SoftwaresController@listdata')->name('softwares.listdata');

	Route::resource('admin/faqs','FaqsController');
	Route::post('admin/faqs/getFaqById','FaqsController@getFaqById')->name('getFaqById');

	Route::resource('admin/testimonials','TestimonialsController');
	Route::post('admin/testimonials/getTestimonialById','TestimonialsController@getTestimonialById')->name('getTestimonialById');

	Route::resource('admin/books','BooksController');
	Route::post('admin/posts/getBookById','BooksController@getBookById')->name('getBookById');
	Route::get('admin/ajaxbooksdata','BooksController@listdata')->name('books.listdata');

	Route::resource('admin/users','RegisterdUsersController');
	Route::post('admin/users/checkExistingUser','RegisterdUsersController@checkExistingUser')->name('checkExistingUser');
	Route::get('admin/userajaxdata','RegisterdUsersController@listdata')->name('users.listdata');

	Route::resource('admin/contacts','ContactsController');
	Route::post('admin/contacts/getContactDataById','ContactsController@getContactDataById')->name('getContactDataById');

	Route::resource('admin/activities','ActivitiesController');
	

	Route::resource('admin/utilities','UtilitiesController');

	Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Auth\LoginController@login');
	Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');

	// Password reset routes
	Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset');
	Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

	//User location 

	Route::get('admin/location','UserTracesController@index')->name('users.location');
	Route::get('admin/locationlist','UserTracesController@listdata')->name('users.location.listdata');
	Route::post('admin/locationDataByUserId','UserTracesController@locationByUserId')->name('users.locationById');
	Route::get('lget','UserTracesController@show');

	//watchlist

	Route::get('admin/watchlist','WatchListController@index')->name('watchlist.list');
	Route::get('admin/allwatchlist','WatchListController@alldata')->name('watchlist.all');

});

Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');

Route::get('/excell','ExcellController@index')->name('excell.index');
Route::post('/import','ExcellController@import')->name('excell.import');
Route::get('checkemail','Auth\RegisterController@checkemail')->name('checkemail');

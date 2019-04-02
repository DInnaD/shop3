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

	//working well in localhost but on the remote server it reports the access denied error. I created this policy after deploying the site on the server so I create a route /clear-cache with code

    // Route::get('/clear-cache', function() {
    //     $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    // });
	Route::get('/', 'HomeController@index')->name('home.index');
	//Route::get('/book/{id}', 'Admin\BooksController@show');
	//Route::get('/magazin/{id}', 'Admin\MagazinsController@show');
	Route::group(['middleware'	=>	'auth'], function(){
		Route::get('/purchasesshow/{slug}', 'PurchasesController@purchase')->name('purchases.show');
		Route::get('/ordersshow/{slug}', 'OrdersController@order')->name('orders.show');	
		Route::get('/cart', 'PurchasesController@indexCart')->name('cart');
		Route::get('/order', 'PurchasesController@index')->name('purchases.index');
		Route::post('/purchase', 'PurchasesController@store');
		Route::get('/purchase/{id}', 'PurchasesController@edit')->name('purchases.edit');//do I use it?
		Route::put('/purchase/{id}/update', 'PurchasesController@update')->name('purchases.update');
		Route::delete('/purchases/{id}/destroy', 'PurchasesController@destroy')->name('purchases.destroy');
		Route::delete('/purchasesAll/destroy', 'PurchasesController@destroyAll')->name('purchases.destroyAll');
		Route::get('/purchasebuy', 'PurchasesController@buy')->name('purchases.buy');
		Route::get('/purchasebuyall', 'PurchasesController@buyAlls')->name('purchases.buyAlls');
		Route::get('/purchases/toggleBeforeToggle/{id}', 'PurchasesController@toggleBeforeToggle');	
		Route::get('/ordersall/{ordersall}', 'OrdersAllsController@index')->name('ordersAll.index');//no table manyToMany
		Route::post('order/{order}/{ordersAll}', 'OrderController@addOrdersAll');
		Route::get('/orders', 'OrdersController@index')->name('orders.index');
		Route::get('/profile', 'ProfileController@index');
		Route::post('/profile', 'ProfileController@store');
		Route::get('/logout', 'AuthController@logout');
	});

	Route::group(['middleware'	=>	'guest'], function(){
	 	Route::get('/register', 'AuthController@registerForm');
	 	Route::post('/register', 'AuthController@register');
	 	Route::get('/login','AuthController@loginForm')->name('login');
	 	Route::post('/login', 'AuthController@login');
	});

	 Route::group(['prefix'=>'admin','namespace'=>'Admin', 'middleware'	=>	'admin'], function(){
	 	Route::get('/', 'DashboardController@index');
		Route::resource('/users', 'UsersController');
		Route::get('/users/toggleAdmin/{id}', 'UsersController@toggleAdmin');
		Route::get('/users/toggleDiscontId/{id}', 'UsersController@toggleDiscontId');
		Route::get('/users/toggleBan/{id}', 'UsersController@toggleBan');
		Route::get('/users/toggleDiscontIdAll', 'UsersController@toggleDiscontIdAll')->name('admin.users.toggleDiscontIdAll');
		//Route::whenRegex('/^admin(\/(?/book)\S+)?S/','Restricted:admin');
		Route::resource('/books', 'BooksController');
		Route::get('/books/toggleDiscontGLB/{id}', 'BooksController@toggleDiscontGLB');
		Route::get('/books/toggleDiscontGLBAll', 'BooksController@toggleDiscontGLBAll')->name('admin.books.toggleDiscontGLBAll');
		Route::get('/books/toggleHard/{id}', 'BooksController@toggleHard');
		//Route::whenRegex('/^admin(\/(?/magazin)\S+)?S/','Restricted:admin');
		Route::resource('/magazins', 'MagazinsController');
		Route::get('/magazins/toggleDiscontGLM/{id}', 'MagazinsController@toggleDiscontGLM');
		Route::get('/magazins/toggleDiscontGLMAll', 'MagazinsController@toggleDiscontGLMAll')->name('admin.magazins.toggleDiscontGLMAll');
		Route::get('/purchases/toggle/{id}', 'PurchasesController@toggle');
		Route::get('/purchases', 'PurchasesController@index')->name('admin.purchases.index');
		Route::delete('/purchases/{id}/destroyAll', 'PurchasesController@destroyAll')->name('purchases.destroyAll');
		Route::get('/purchasesdaybefore', 'PurchasesController@indexDayBefore')->name('admin.purchases.indexDayBefore');
		Route::get('/purchasesweekbefore', 'PurchasesController@indexWeekBefore')->name('admin.purchases.indexWeekBefore');
		Route::get('/purchasesmonthbefore', 'PurchasesController@indexMonthBefore')->name('admin.purchases.indexMonthBefore');
		Route::get('/statistics', 'StatisticsController@index')->name('admin.statistics.index');
		Route::get('/statistics', 'StatisticsController@show')->name('admin.statistics.show');

	 });

	// Route::get('book/{book_id}/{publisher_id}', 'BookController@setPublisher');
 //    Route::get('book', 'BookController@index');
 //    Route::get('book/{book}', 'BookController@show');
 //    Route::post('book', 'BookController@store');
 //    Route::delete('book/{book}', 'BookController@destroy');
 //    Route::put('book/{book}', 'BookController@update');

	
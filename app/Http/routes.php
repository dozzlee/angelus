<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

  //Index routes...
  Route::get('/welcome', function () {
      return view('welcome');
  });

  Route::get('/404', function () {
      return view('errors.503');
  });

  // Authentication routes...
  Route::get('auth/login', ['as' => 'login-user', 'uses' => 'Auth\AuthController@getLogin']);
  Route::post('auth/login', 'Auth\AuthController@postLogin');
  Route::get('auth/logout', ['as' => 'logout-user', 'uses' => function() {
    Auth::logout();
    return redirect('/auth/login');
  }]);

  // Registration routes...
  Route::get('auth/register', 'Auth\AuthController@getRegister');
  Route::post('auth/register', 'Auth\AuthController@postRegister');

  Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
      return "This page requires that you be logged in and an Admin";
  }]);

  //Product
  Route::get('/product/{productId}', ['as' => 'product.details', 'uses' => function($productId){
    $cartModule = new \App\Http\Controllers\Api\CartModule();
    $productModule = new \App\Http\Controllers\Api\ProductModule();
    // $cart = $cartModule->getCartForUserById(Auth::user()->id);
    $product = $productModule->getProductsById($productId);

    return view('product.view', ['product' => $product, 'cart'  => [], 'total' => 0, 'quantity' => 0]);
  }]);

  Route::get('confirm/{confirmLink}', function($confirmLink){
    if(!Auth::check()){
      return \App()->make('\App\Http\Controllers\ProductController')->callAction('index', $parameters = array());
    }

    $userID = Auth::user()->id;
    $user_obj = new \App\User();
    $user = $user_obj::findOrFail($userID);

    if($confirmLink == $user->confirm_link){
      $user->is_verified = 1;
      $user->save();
    }

    return redirect('/');
  });
});

Route::group(['middleware' => ['auth']], function () {
  //Cart routes...
  Route::get('/carts/add/{productId}', ['uses' => 'CartController@addItem']);
  Route::post('/carts/add', ['as' => 'cart-add-item', 'uses' => 'CartController@addItems']);
  Route::get('/carts/add', ['as' => 'cart-add-item', 'uses' => 'CartController@addItems']);
  Route::post('/carts/edit', ['as' => 'cart-edit-item', 'uses' => 'CartController@editItem']);
  Route::get('/carts/{productId}/delete', ['uses' => 'CartController@removeItem']);
  Route::get('/cart', ['uses' => 'CartController@showCart']);

  //Order routes
  Route::get('order/{orderId}', ['uses' => 'OrderController@viewOrder']);
  Route::get('order', ['uses' => 'OrderController@index']);
  Route::post('/order/edit', ['as' => 'order-edit-item', 'uses' => 'OrderController@editOrder']);
  Route::get('download/{orderId}/{filename}', ['uses' => 'OrderController@download']);

  //Checkout routes
  Route::get('/checkout', ['as' => 'checkout', 'uses' => function(){
    $link = \App()->make('\App\Http\Controllers\ProductController')->callAction('index', $parameters = array());

    if(!Auth::check()){
      return $link;
    }

    $cartModule = new \App\Http\Controllers\Api\CartModule();
    $cart = $cartModule->getCartForUserById(Auth::user()->id);

    if(!$cart['cart']){
      return $link;
    }

    return view('checkout.view')->with($cart);
  }]);

  Route::post('/checkout', ['as' => 'order-checkout', 'uses' => 'OrderController@checkout']);

  //Tracking
  Route::post('/tracking', ['as' => 'order-tracking', 'uses' => 'OrderController@tracking']);
  Route::get('tracking/{trackingID}', ['uses' => 'OrderController@viewTracking']);
  Route::get('/tracking', ['as' => 'tracking', 'uses' => function(){
    $cartModule = new \App\Http\Controllers\Api\CartModule();
    $cart = $cartModule->getCartForUserById(Auth::user()->id);

    return view('tracking.track')->with($cart);
  }]);

  //admin
  Route::post('/profile/edit', ['as' => 'profile-edit', 'uses' => 'AdminController@editProfile']);
  Route::post('/admin/profiles', ['as' => 'admin-profile-edit', 'uses' => 'AdminController@editAdminProfile']);
});

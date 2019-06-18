<?php 

$router->get('admin/product/new', [
	'uses' => 'App\Http\Controllers\AdminController@viewAddProduct',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('profile', [
	'uses' => 'App\Http\Controllers\AdminController@viewProfile',
	'as' => NULL,
	'middleware' => ['auth'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/profiles', [
	'uses' => 'App\Http\Controllers\AdminController@viewAllProfiles',
	'as' => NULL,
	'middleware' => ['auth'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/products', [
	'uses' => 'App\Http\Controllers\AdminController@getProducts',
	'as' => 'admin-products',
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->post('admin/products/edit', [
	'uses' => 'App\Http\Controllers\AdminController@editItem',
	'as' => 'product-edit-item',
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/product/destroy/{id}', [
	'uses' => 'App\Http\Controllers\AdminController@deleteProductById',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->post('admin/product/add', [
	'uses' => 'App\Http\Controllers\AdminController@addNewProduct',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/orders', [
	'uses' => 'App\Http\Controllers\AdminController@getOrders',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/order/new', [
	'uses' => 'App\Http\Controllers\AdminController@viewAddOrder',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/order/{id}', [
	'uses' => 'App\Http\Controllers\AdminController@viewOrder',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/order/destroy/{id}', [
	'uses' => 'App\Http\Controllers\AdminController@deleteOrderById',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('admin/user/destroy/{id}', [
	'uses' => 'App\Http\Controllers\AdminController@deleteProfile',
	'as' => NULL,
	'middleware' => ['admin'],
	'where' => [],
	'domain' => NULL,
]);

$router->get('forgotpassword', [
	'uses' => 'App\Http\Controllers\AdminController@viewForgotpassword',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('resetpassword/{token}', [
	'uses' => 'App\Http\Controllers\AdminController@viewResetpassword',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('forgotpassword', [
	'uses' => 'App\Http\Controllers\AdminController@emailForgotpassword',
	'as' => 'forgot-password',
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('resetpassword/{token}', [
	'uses' => 'App\Http\Controllers\AdminController@resetPassword',
	'as' => 'reset-password',
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/carts', [
	'uses' => 'App\Http\Controllers\Api\CartModule@getCarts',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/carts/{id}', [
	'uses' => 'App\Http\Controllers\Api\CartModule@getCartById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/user/{id}/cart', [
	'uses' => 'App\Http\Controllers\Api\CartModule@getCartForUserById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/user/{id}/product/{productId}/qty/{quantity}', [
	'uses' => 'App\Http\Controllers\Api\CartModule@editCart',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('v1/api/carts/{userId}/add', [
	'uses' => 'App\Http\Controllers\Api\CartModule@addNewCart',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('v1/api/carts/{id}/add/{itemId}', [
	'uses' => 'App\Http\Controllers\Api\CartModule@addCartItem',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->delete('v1/api/carts/{id}', [
	'uses' => 'App\Http\Controllers\Api\CartModule@deleteCartById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->delete('v1/api/carts/{id}/delete', [
	'uses' => 'App\Http\Controllers\Api\CartModule@deleteCartItemById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/orders', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@getOrders',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/orders/{id}/valid', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@orderIDExists',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/orders/{id}', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@getOrdersById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/user/{id}/orders', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@getOrdersForUserById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('v1/api/orders/add', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@addNewOrder',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('v1/api/orders/{id}/add/{itemId}', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@addOrderItem',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->delete('v1/api/orders/{id}', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@deleteOrderById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->delete('v1/api/orders/{id}/delete', [
	'uses' => 'App\Http\Controllers\Api\OrderModule@deleteOrderItemById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/products', [
	'uses' => 'App\Http\Controllers\Api\ProductModule@getProducts',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('v1/api/products/{id}', [
	'uses' => 'App\Http\Controllers\Api\ProductModule@getProductsById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->post('v1/api/products/add', [
	'uses' => 'App\Http\Controllers\Api\ProductModule@addNewProduct',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->delete('v1/api/products/{id}', [
	'uses' => 'App\Http\Controllers\Api\ProductModule@deleteProductById',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('/', [
	'uses' => 'App\Http\Controllers\ProductController@index',
	'as' => 'home',
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

$router->get('products/download/{productId}/{filename}', [
	'uses' => 'App\Http\Controllers\ProductController@productDownload',
	'as' => NULL,
	'middleware' => [],
	'where' => [],
	'domain' => NULL,
]);

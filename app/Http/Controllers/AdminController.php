<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ProductModule;
use App\Http\Controllers\Api\OrderModule;
use App\Http\Controllers\Api\CartModule;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;
use App\User;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminController extends Controller {

  private $products, $orders, $carts, $userID;

  public function __construct(ProductModule $products, OrderModule $orders, CartModule $carts){
    $this->carts = $carts;
    $this->orders = $orders;
    $this->products = $products;
    $this->userID = Auth::check() ? Auth::user()->id : -1;
  }

  /**
  * @Get("/admin/product/new")
  * @Middleware("admin")
  */
  public function viewAddProduct(){
    $cart = $this->carts->getCartForUserById($this->userID);

    return view('admin.new', ['cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/profile")
  * @Middleware("auth")
  */
  public function viewProfile(){
    $cart = $this->carts->getCartForUserById($this->userID);
    $user = Auth::user();
    $address_obj = new Address();
    $address = $address_obj->where('user_id', $user->id)->first();

    return view('profile.view', ['user' => $user, 'address'=>$address, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/admin/profiles")
  * @Middleware("auth")
  */
  public function viewAllProfiles(){
    $cart = $this->carts->getCartForUserById($this->userID);
    $users = User::all();

    return view('admin.profile', ['users' => $users, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  public function editAdminProfile(Request $request){
    $adminStatus = $request->input('admin_status');
    $userID = $request->input('userID');

    $user = User::where('id', $userID)->first();
    $admin_exist = User::where('is_admin', 1)->get();

    if($admin_exist && $admin_exist[0]->id == $userID && $adminStatus == 0){
      return redirect('/admin/profiles')->with('error', 'At least one user must be an admin');
    }

    if($user){
      $user->is_admin = $adminStatus;
      $user->save();
    }

    return redirect('/admin/profiles');
  }

  public function editProfile(Request $request){
    $lastName = $request->input('lastName');
    $firstName = $request->input('firstName');
    $phoneNumber = $request->input('phoneNumber');
    $email = $request->input('email');
    $user = Auth::user();

    $user_obj = User::all()->where('email', $email);

    if(count($user_obj) <= 0){
      $user->email = $email;
    }

    $user->first_name = $firstName;
    $user->last_name = $lastName;
    $user->phone_number = $phoneNumber;
    $user->save();

    return redirect('/profile');
  }

  /**
  * @Get("/admin/products", as="admin-products")
  * @Middleware("admin")
  */
  public function getProducts(){
      $prod = $this->products->getProducts();
      $cart = $this->carts->getCartForUserById($this->userID);

      foreach($prod as $p){
        $p->original_filename = \App\Models\File::where('id', $p->file_id)->first()->original_filename;
      }

      return view('admin.products',['products' => $prod, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Post("/admin/products/edit", as="product-edit-item")
  * @Middleware("admin")
  * @return $this|\Illuminate\Http\RedirectResponse
  */
  public function editItem(Request $request){
    $productId = $request->input('productId');
    $productName = $request->input('productName');
    $productPrice = $request->input('productPrice');
    $productStock = $request->input('productStock');
    $productDescription = $request->input('productDescription');
    $user_id = $this->userID;
    $is_admin = Auth::user()->is_admin;

    if(!$is_admin){
      return redirect('/admin/products');
    }

    $product = Product::where('id', $productId)->first();
    $product->name = $productName;
    $product->product_stock = $productStock;
    $product->price = $productPrice;
    $product->description = $productDescription;
    $product->save();

    return redirect('/admin/products');
  }

  /**
  * @Get("/admin/product/destroy/{id}")
  * @Middleware("admin")
  */
  public function deleteProductById($id){
      $this->products->deleteProductById($id);
      return redirect('/admin/products');
  }

  /**
  * @Post("/admin/product/add")
  * @Middleware("admin")
  * @return $this|\Illuminate\Http\RedirectResponse
  */
  public function addNewProduct() {
      $processed = $this->products->addNewProduct();
      return redirect()->route('admin-products')->with('successful', $processed->getData());
  }

  /****************************************************
  ****************** ORDER CODE ***********************
  ****************************************************/
  /**
  * @Get("/admin/orders")
  * @Middleware("admin")
  */
  public function getOrders(){
      $prod = $this->products->getProducts();
      $order = $this->orders->getOrders();
      $cart = $this->carts->getCartForUserById($this->userID);

      foreach($prod as $p){
        $p->original_filename = \App\Models\File::where('id', $p->file_id)->first()->original_filename;
      }

      return view('admin.orders', ['orders' => $order, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/admin/order/new")
  * @Middleware("admin")
  * TODO: Create view for this section
  */
  public function viewAddOrder(){
      return view('admin.new');
  }

  /**
  * @Get("/admin/order/{id}")
  * @Middleware("admin")
  */
  public function viewOrder($id){
      $order = $this->orders->getOrdersById(new Request(), $id);
      $cart = $this->carts->getCartForUserById($this->userID);

      return view('admin.order-item',['order'=>$order, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/admin/order/destroy/{id}")
  * @Middleware("admin")
  */
  public function deleteOrderById($id){
      $this->orders->deleteOrderById($id);
      return redirect('/admin/orders');
  }

  /**
  * @Get("/admin/user/destroy/{id}")
  * @Middleware("admin")
  */
  public function deleteProfile($id){
    $user = User::all();
    $admin_exist = User::where('is_admin', 1)->get();

    if(count($admin_exist) <= 1){
      return redirect('/admin/profiles')->with('error', 'At least one admin user must exist in system.');
    }

    User::findOrFail($id)->delete();
    return redirect('/admin/profiles');
  }

  /**
  * @Get("/forgotpassword")
  */
  public function viewForgotpassword(){
    $cart = $this->carts->getCartForUserById($this->userID);

    return view('auth.forgotpassword',['cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/resetpassword/{token}")
  */
  public function viewResetpassword($token){
    $cart = $this->carts->getCartForUserById($this->userID);

    return view('auth.changepassword',['token' => $token, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Post("/forgotpassword", as="forgot-password")
  */
  public function emailForgotpassword(Request $request){
    $email = $request->input('email');
    $email_exist = User::where('email', $email)->first();

    if(count($email_exist) <= 0){
      return redirect('/forgotpassword')->with('error', 'No account associated with this email address.');
    }

    //Create token and set in DB
    $token = str_random(30);
    $reset_link = env('APP_BASE_LINK').'/resetpassword/' . $token;
    \DB::insert('insert into password_resets (user_id, token) values (?, ?)', array($email_exist->id, $token));

    //Prepare email vars
    $account_name = $email_exist->first_name.' '.$email_exist->last_name;
    $email_data = array(
      'account_name' => $account_name,
      'reset_link' => $reset_link,
      'web_link' =>'http://www.placehold.it/50x50',
      'logo_link' => 'http://www.placehold.it/50x50',
    );

    //Sends email to user
    \Mail::send('emails.forgot', $email_data, function($message) use ($email, $account_name){
        $message->to($email, $account_name)->subject('Account Password Reset Instructions');
    });

    return redirect('forgotpassword')->with('successful', 'Email instructions sent to your email address.');
  }

  /**
  * @Post("/resetpassword/{token}", as="reset-password")
  */
  public function resetPassword(Request $request, $token){

    $password = $request->input('password1');
    $reset_obj = \DB::table('password_resets')->where('token', $token)->first();

    if(!$reset_obj){
      return redirect('forgotpassword')->with('successful', 'Invalid reset token.');
    }

    $userID = $reset_obj->user_id;

    $user = User::where('id', $userID)->first();
    $user->password = bcrypt($password);
    $user->save();

    \DB::table('password_resets')->where('user_id', $userID)->delete();

    return redirect('forgotpassword')->with('successful', 'Account password was successfully reset.');
  }

}

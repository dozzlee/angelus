<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Http\Controllers\Api\CartModule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller {

  private $cart;
  private $userID;

  public function __construct(CartModule $cart){
    $this->cart = $cart;
    $this->userID = Auth::check() ? Auth::user()->id : -1;
  }

  public function addItem ($productId){
      $cart = $this->cart->getCartForUserById($this->userID);

      if(!$cart['cart']){
        $cart = $this->cart->addNewCart(new Request(), $this->userID);
        $this->cart->addCartItem(new Request(), $cart->id, $productId);
      }else{
        $this->cart->addCartItem(new Request(), $cart['cart'][0]->cart->id, $productId);
      }

      return redirect('/cart');
  }

  public function addItems (Request $request) {
      $productId = $request->input('productId');
      $quantity_request = $request->input('quantity');
      $cart;

      $cart = (new Cart())->where('user_id', $this->userID)->first();

      //Check if items exist in cart
      if(!$cart){
        $cart = new Cart();
        $cart->user_id =  $this->userID;
        $cart->save();
      }

     $quantity = $quantity_request > 0 ? $quantity_request : 1;

      while($quantity > 0){
        $this->cart->addCartItem(new Request(), $cart->id, $productId);
        $quantity--;
      }

      return redirect('/cart');
  }

  public function editItem(Request $request){
    $productId = $request->input('productId');
    $quantity = $request->input('quantity');

    if($quantity <= 0){
      return redirect('/cart');
    }

    //Edit cart
    $this->cart->editCart($this->userID, $productId, $quantity);

    return redirect('/cart');
  }

  public function showCart(){
    $cart = $this->cart->getCartForUserById($this->userID);
    return view('cart.view', ['cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity'], 'quantity' => $cart['quantity']]);
  }

  public function removeItem($id){
      $this->cart->deleteCartItemById(new Request(), $id);
      return redirect('/cart');
  }
}

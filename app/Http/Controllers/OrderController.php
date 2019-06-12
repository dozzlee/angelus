<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\OrderModule;
use App\Http\Controllers\Api\CartModule;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Address;
use App\User;

class OrderController extends Controller {
  private $orders, $carts, $userID;

  public function __construct(OrderModule $orders, CartModule $carts){
    $this->orders = $orders;
    $this->carts = $carts;
    $this->userID = Auth::check() ? Auth::user()->id : -1;
  }

  public function checkout(Request $request) {
      $validator = \Validator::make(\Input::all(), [
          'first_name' => 'required|string|min:2|max:32',
          'last_name' => 'required|string|min:2|max:32',
          'email' => 'required|email',
      ]);

      if ($validator->fails()) {
          return redirect()->back()
              ->withErrors($validator)
              ->withInput();
      }

      $token = $request->input('stripeToken');

      //Sanitize values
      $first_name = $request->input('first_name');
      $last_name = $request->input('last_name');
      $full_name = "Strip account for ".$first_name." ".$last_name;
      $email = $request->input('email');
      $user = User::where('email', $email)->first();

      //Shippping Information
      $country = $request->input('country');
      $state = $request->input('state');
      $phone_number = $request->input('phone_number');
      $zip_code = $request->input('zip_code');
      $address_line_1 = $request->input('address_line');
      $address_line_2 = $request->input('address_line2');

      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      // If the email doesn't exist in the database create new customer and user record
      if (!isset($user)) {
          // Create a new Stripe customer
          try {
              $customer = \Stripe\Customer::create([
              'source' => $token,
              'email' => $email,
              'description' => $full_name,
              'metadata' => [
                  "First Name" => $first_name,
                  "Last Name" => $last_name
              ]
              ]);
          } catch (\Stripe\Error\Card $e) {
              return redirect()->route('order')
                  ->withErrors($e->getMessage())
                  ->withInput();
          }

          $customerID = $customer->id;

          // Create a new user in the database with Stripe
          //TODO:Assign password and email client
          $user = User::create([
              'first_name' => $first_name,
              'last_name' => $last_name,
              'email' => $email,
              'stripe_customer_id' => $customerID,
              ]);
      } else {
          $customerID = $user->stripe_customer_id;

          if(empty($customerID)){
            // Create a new Stripe customer
            try {
                $customer = \Stripe\Customer::create([
                  'source' => $token,
                  'email' => $email,
                  'description' => $full_name,
                  'metadata' => [
                      "First Name" => $first_name,
                      "Last Name" => $last_name
                  ]
                ]);
            } catch (\Stripe\Error\Card $e) {
                return redirect()->route('order')
                    ->withErrors($e->getMessage())
                    ->withInput();
            }

            $customerID = $customer->id;
            $user->stripe_customer_id = $customerID;
            $user->save();

          }
      }

      //Retriieve cart information
      $cart = $this->carts->getCartForUserById(Auth::user()->id);
      $items = $cart['cart'];
      $total = 0;
      $productItems = array();
      $products = array();

      foreach($items as $item) {
        $price = $item->product->price;
        $productName = $item->product->name;

        $total += ($item->product->price * $item->quantity);
        array_push($productItems, array("name" => $productName, "price" => $price));
      }
      $products = array("products" => $productItems, "total" => $total);

      // Charging the Customer with the selected amount
      try {
          $charge = \Stripe\Charge::create([
              'amount' => $total * 100,
              'currency' => 'usd',
              'customer' => $customerID,
              'description' => 'Payment from Casper Store',
              'metadata' => [
                  'order_id' => '',
                  'shipping_tracking' => ''
              ]
          ]);

          if($charge){

            //Create new order request
            $orderRequest = request();
            $orderRequest->request->add(['userId' => Auth::user()->id]);
            $orderRequest->request->add(['amount' => $total]);
            $orderRequest->request->add(['transactionId' => $charge->id]);
            $order = $this->orders->addNewOrder($orderRequest);

            //Add order item and remove from cart
            $product_inventory_obj = new Product();

            foreach($items as $item){
              $this->orders->addOrderItem($order->id, $item->product->id, $item->quantity);
              $this->carts->deleteCartItemById(new Request(), $item->id);
              $product_inventory = $product_inventory_obj::findOrFail($item->product->id);
              $product_inventory->product_stock -= $item->quantity;
              $product_inventory->save();
            }

            //Store shipping information
            $shipping_address = new Address();
            $shipping_address->country = $country;
            $shipping_address->state = $state;
            $shipping_address->phone_number = $phone_number;
            $shipping_address->zip_code = $zip_code;
            $shipping_address->address_line_1 = $address_line_1;
            $shipping_address->address_line_2 = $address_line_2;
            $shipping_address->user_id = $this->userID;
            $shipping_address->order_id = $order->id;

            $shipping_address->save();

            //Update stripe transaction metadata with order_id info
            $retrieve_charge = \Stripe\Charge::retrieve($charge->id);
            $retrieve_charge->metadata['order_id'] = $order->id;
            $retrieve_charge->save();
          }

         return redirect('/order/'.$order->id);

      } catch (\Stripe\Error\Card $e) {
          return redirect()->route('order')
              ->withErrors($e->getMessage())
              ->withInput();
      }

      return redirect('/cart');

  }

  public function tracking(Request $request){
    $validator = \Validator::make(\Input::all(), [
        'tracking_id' => 'required|string|min:1|max:32',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    //Sanitize values
    $tracking_id = $request->input('tracking_id');
    $order = $this->orders->orderIDExists(new Request(), $tracking_id);

    return $order ? redirect('/tracking/'.$tracking_id) : redirect()->back()
        ->withErrors($validator)
        ->withInput();
  }

  public function index(){

    $orders = $this->orders->getOrdersForUserById($this->userID)->getData();
    $cart = $this->carts->getCartForUserById($this->userID);

    return view('order.list', ['orders'=>$orders, 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  public function viewOrder($orderId){
    $user_id = $this->userID;
    $is_admin = Auth::user()->is_admin;
    $order = $this->orders->getOrdersById(new Request(), $orderId);

    if($order->user_id != $user_id && !$is_admin){
      return redirect('/order');
    }

    $cart = $this->carts->getCartForUserById($this->userID);

    return view('order.view',['order'=>$order,'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  public function editOrder(Request $request){
    $orderId = $request->input('orderId');
    $status = $request->input('order_status');

    $order_exists = $this->orders->orderIDExists(new Request(), $orderId);

    if(!$order_exists){
      return redirect('/admin/orders');
    }

    $order_obj = new Order();
    $order = $order_obj::findOrFail($orderId);
    $order->order_progress = $status;
    $order->save();

    return redirect('/admin/orders');
  }

  public function viewTracking($trackingID){

      $order = $this->orders->getOrdersById(new Request(), $trackingID);
      $cart = $this->carts->getCartForUserById($this->userID);

      return view('tracking.view',['order'=>$order,'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  public  function download($orderId, $filename){

      $fileid = \App\Models\File::where('filename',$filename)->first();
      $orderItem = OrderItem::where('order_id','=',$orderId)->where('file_id',$fileid->id)->first();

      if(!$orderItem){
        return redirect('/404');
      }

      $entry = \App\Models\File::where('filename',$filename)->first();
      $file = Storage::disk('local')->get($entry->filename);

      return (new Response($file, 200))->header('Content-Type', $entry->mime);
  }
}

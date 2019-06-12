<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ProductModule;
use App\Http\Controllers\Api\CartModule;
use App\Models\Product;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ProductController extends Controller{

  private $products, $carts, $userID;

  public function __construct(ProductModule $products, CartModule $carts){
    $this->products = $products;
    $this->carts = $carts;
    $this->userID = Auth::check() ? Auth::user()->id : -1;
  }

  /**
  * @Get("/", as="home")
  */
  public function index(){
    $cart = $this->carts->getCartForUserById($this->userID);
    return view('main.index', ['products' => $this->products->getProducts(), 'cart' => $cart['cart'], 'total' => $cart['total'], 'quantity' => $cart['quantity']]);
  }

  /**
  * @Get("/products/download/{productId}/{filename}")
  */
  public function productDownload($productId, $filename){

    $fileid = \App\Models\File::where('filename',$filename)->first();
    $productItem = Product::where('id','=',$productId)->where('file_id',$fileid->id)->first();

    if(!$productItem){
      return redirect('/404');
    }

    $entry = \App\Models\File::where('filename',$filename)->first();
    $file = Storage::disk('local')->get($entry->filename);

    return (new Response($file, 200))->header('Content-Type', $entry->mime);
  }
}

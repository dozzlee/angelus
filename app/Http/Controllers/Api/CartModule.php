<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
// use Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Class CartModule
 *
 * @Controller(prefix="v1/api")
 *
 * @package App\Http\Controllers\Api
 */
class CartModule extends ApiController
{

  /**
   * Returns all cart
   * @Get("carts")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/carts",
   *     description="Returns all carts.",
   *     summary="Get all carts",
   *     operationId="get.carts",
   *     produces={"application/json"},
   *     tags={"Cart"},
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve all carts.",
   *         @SWG\Schema(ref="#/definitions/Cart"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching carts.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getCarts(){
    try{
        $statusCode = 200;
        $response = Cart::all();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching cart"
             ]
         ];
     }finally{
         return \Response::json($response, $statusCode);
     }

  }

  /**
   * Returns cart by id
   * @Get("carts/{id}")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/carts/{id}",
   *     description="Returns cart based on a specific ID",
   *     summary="Retrieve a specific existing cart",
   *     operationId="get.cart.for.id",
   *     produces={"application/json"},
   *     tags={"Cart"},
   *    @SWG\Parameter(
   *         description="ID of specific cart that needs to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve cart based on a specific ID",
   *         @SWG\Schema(ref="#/definitions/Cart"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching cart.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getCartById($id){
    try{
        $statusCode = 200;

        $response = Cart::findOrFail($id)->first();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching cart"
             ]
         ];
     }finally{
         return \Response::json($response, $statusCode);
        // return $response;
     }

  }

  /**
   * Returns cart by user id
   * @Get("user/{id}/cart")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/user/{id}/cart",
   *     description="Returns cart based on a specific user ID",
   *     summary="Retrieve an existing cart for user",
   *     operationId="get.cart.for.user.via.id",
   *     produces={"application/json"},
   *     tags={"Cart"},
   *    @SWG\Parameter(
   *         description="ID of user for cart to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve cart based on a specific user ID",
   *         @SWG\Schema(ref="#/definitions/Cart"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching cart.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getCartForUserById($id){
    try{
        $statusCode = 200;

        $cart = Cart::where('user_id', $id)->first();

        if(!$cart){
            $response = ['cart'=> [],'total'=> 0];
        }

        $total = 0;
        $quantity = 0;
        $user_cart = $cart->cartItems;
        foreach($user_cart as $item){
            $total += $item->product->price * $item->quantity;
            $quantity += $item->quantity;
        }

        $response = ['cart' => $user_cart, 'total' => $total, 'quantity' => $quantity];

     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
           'cart' => [],
           'total' => 0,
           'quantity' => 0,
           'error' =>
             [
                 "code" => $statusCode,
                 "message" => "Error fetching cart"
             ]
         ];
     }finally{
        //  return \Response::json($response, $statusCode);
        return $response;
     }

  }

  /**
   * Returns cart by user id
   * @Get("/user/{id}/product/{productId}/qty/{quantity}")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/user/{id}/product/{productId}/qty/{quantity}",
   *     description="Edit cart based on a specific user ID",
   *     summary="Edit an existing cart for user",
   *     operationId="edit.cart.for.user.via.id",
   *     produces={"application/json"},
   *     tags={"Cart"},
   *    @SWG\Parameter(
   *         description="ID of user for cart to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *    @SWG\Parameter(
   *         description="ProductId in cart to be edited",
   *         in="path",
   *         name="productId",
   *         required=true,
   *         type="string"
   *     ),
   *    @SWG\Parameter(
   *         description="Quanty to be edited",
   *         in="path",
   *         name="quantity",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Edit cart based on a specific user ID",
   *         @SWG\Schema(ref="#/definitions/Cart"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching cart.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function editCart($id, $productId, $quantity){
    try{
        $statusCode = 200;

        $cart = Cart::where('user_id', $id)->first();

        if(!$cart){
          $response = ['cart'=> [],'total'=> 0];
        }

        $user_cartObj = $cart->cartItems()->where('product_id', $productId)->first();
        $user_cartObj->quantity = $quantity;
        $user_cartObj->save();

        $response = $cart;

     }catch (Exception $e){
         $statusCode = 404;
         $response = [
           'cart' => [],
           'total' => 0,
           'quantity' => 0,
           'error' =>
             [
                 "code" => $statusCode,
                 "message" => "Error fetching cart"
             ]
         ];
     }finally{
        //  return \Response::json($response, $statusCode);
        return $response;
     }
  }

   /**
     * Creates a new cart
     * @Post("carts/{userId}/add")
     *
     * @return \Illuminate\Http\Response
     *
     * @SWG\Post(
     *     path="/carts/{userId}/add",
     *     description="Creates a new cart",
     *     summary="Create a cart",
     *     operationId="create.cart",
     *     produces={"application/json"},
     *     tags={"Cart"},
     *    @SWG\Parameter(
     *         description="Unique Id of user for which cart is to be created",
     *         in="path",
     *         name="userId",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="List of user cart",
     *         @SWG\Schema(ref="#/definitions/Cart")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Error creating cart",
     *         @SWG\Schema(
     *             ref="#/definitions/ErrorModel"
     *         )
     *     )
     * )
     */
    public function addNewCart(Request $request, $userId){
        try{
            $statusCode = 200;

            $user = User::findOrFail($userId)->first();
            if(!$user){
              throw new \Exception("Error obtaining user id");
            }

            if(Cart::where('user_id', $userId)->exists()){
              throw new \Exception("User already has active cart");
            }

            //Create cart
            $cart = new Cart();
            $cart->user_id =  $userId;
            $cart->save();

            $response = $cart;
        }catch (\Exception $e){
            $statusCode = 400;
            $response = [
                [
                    "code" => $statusCode,
                    "message" => $e->getMessage()
                ]
            ];

        }finally{
            // return \Response::json($response, $statusCode);
            return $response;
        }
    }

    /**
    * Creates a new cart item
    * @Post("carts/{id}/add/{itemId}")
    *
    * @return \Illuminate\Http\Response
    *
    * @SWG\Post(
    *     path="/carts/{id}/add/{itemId}",
    *     description="Creates a new cart item",
    *     summary="Creates a cart item",
    *     operationId="create.cart.item",
    *     produces={"application/json"},
    *     tags={"Cart"},
    *    @SWG\Parameter(
    *         description="ID of specific cart that needs to be retrieved",
    *         in="path",
    *         name="id",
    *         required=true,
    *         type="string"
    *     ),
    *    @SWG\Parameter(
    *         description="ID of specific product to be added to the cart",
    *         in="path",
    *         name="itemId",
    *         required=true,
    *         type="string"
    *     ),
    *     @SWG\Response(
    *         response="201",
    *         description="List of cart",
    *         @SWG\Schema(ref="#/definitions/CartItem")
    *     ),
    *     @SWG\Response(
    *         response="404",
    *         description="Error creating cart",
    *         @SWG\Schema(
    *             ref="#/definitions/ErrorModel"
    *         )
    *     )
    * )
    */
    public function addCartItem(Request $request, $id, $itemId){
       try{
           $statusCode = 200;

           if(!$id){
             throw new \Exception("No cart id found");
           }

           if(!$itemId || !Product::where('id', $itemId)->exists()){
             throw new \Exception("Item doesn't exist in inventory");
           }

           $cart = Cart::where('id', $id)->first();
           $cartItem = CartItem::where('cart_id', $id)->where('product_id', $itemId)->first();

           if($cartItem){
             $cartItem->quantity++;
             $cartItem->save();
           }else{
             $cartItem  = new Cartitem();
             $cartItem->product_id = $itemId;
             $cartItem->cart_id = $cart->id;
             $cartItem->quantity = 1;
             $cartItem->save();
           }

           $cartItems = CartItem::where('cart_id', $id)->get();
           $cart->cart_items = $cartItems;

           $response = $cart;
       }catch (\Exception $e){
           $statusCode = 200;
           $response = [
               [
                   "code" => $statusCode,
                   "message" => $e->getMessage()
               ]
           ];
       }finally{
           return \Response::json($response, $statusCode);
       }
    }

    /**
     * Delete cart by id
     * @Delete("carts/{id}")
    *
    * @return \Illuminate\Http\Response
    *
    * @SWG\Delete(
    *     path="/carts/{id}",
    *     description="Deletes cart based on a specific ID",
    *     summary="Delete a specific existing cart",
    *     operationId="delete.cart.for.id",
    *     produces={"application/json"},
    *     tags={"Cart"},
    *     @SWG\Parameter(
    *         description="ID of specific cart that needs to be deleted",
    *         in="path",
    *         name="id",
    *         required=true,
    *         type="string"
    *     ),
    *     @SWG\Response(
    *         response="204",
    *         description="No content",
    *         @SWG\Schema(ref="#/definitions/ErrorModel")
    *     ),
    *     @SWG\Response(
    *         response="404",
    *         description="Error deleting cart item",
    *         @SWG\Schema(
    *             ref="#/definitions/ErrorModel"
    *         )
    *     )
    * )
    */
    public function deleteCartById($id){
          try{
              $statusCode = 204;
              Cart::findOrFail($id)->delete();

              $response = "";

          }catch (\Exception $e){
              $statusCode = 204;
              $response = [
                  [
                      "code" => $statusCode,
                      "message" => "No content"
                  ]
              ];
          }finally{
              return \Response::json($response, $statusCode);
          }
      }


      /**
       * Delete cart item by id
       * @Delete("carts/{id}/delete")
      *
      * @return \Illuminate\Http\Response
      *
      * @SWG\Delete(
      *     path="/carts/{id}/delete",
      *     description="Deletes cart item based on a specific ID",
      *     summary="Delete a specific existing cart item",
      *     operationId="delete.cart.item.for.id",
      *     produces={"application/json"},
      *     tags={"Cart"},
      *     @SWG\Parameter(
      *         description="ID of specific cart item that needs to be deleted",
      *         in="path",
      *         name="id",
      *         required=true,
      *         type="string"
      *     ),
      *     @SWG\Response(
      *         response="204",
      *         description="No content",
      *         @SWG\Schema(ref="#/definitions/ErrorModel")
      *     ),
      *     @SWG\Response(
      *         response="404",
      *         description="Error deleting cart item",
      *         @SWG\Schema(
      *             ref="#/definitions/ErrorModel"
      *         )
      *     )
      * )
      */
      public function deleteCartItemById(Request $request, $id){
          try{
              $statusCode = 200;

              $cartItem = CartItem::findOrFail($id);
              $cart_id = $cartItem->cart_id;
              $cartItem->delete();

              //Destroy cart if all items are deleted
              if (!CartItem::where('cart_id', $cart_id)->exists()) {
                 Cart::destroy($cart_id);
              }

              $response = "Cart item successfully deleted";
          }catch (\Exception $e){
              $statusCode = 200;
              $response = [
                  [
                      "code" => $statusCode,
                      "message" => $e->getMessage()
                  ]
              ];
          }finally{
              return \Response::json($response, $statusCode);
          }
      }

}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\User;

/**
 * Class OrderModule
 *
 * @Controller(prefix="v1/api")
 *
 * @package App\Http\Controllers\Api
 */
class OrderModule extends ApiController
{

  /**
   * Returns all orders
   * @Get("orders")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/orders",
   *     description="Returns all orders.",
   *     summary="Get all orders",
   *     operationId="get.orders",
   *     produces={"application/json"},
   *     tags={"Order"},
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve all orders.",
   *         @SWG\Schema(ref="#/definitions/Order"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching order.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getOrders(){
    try{
        $statusCode = 200;
        $response = Order::all();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching orders"
             ]
         ];
     }finally{
        //  return \Response::json($response, $statusCode);
         return $response;
     }

  }

  /**
   * Returns boolean if order exists
   * @Get("orders/{id}/valid")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/orders/{id}/valid",
   *     description="Checks if order is present in current ordered items in DB",
   *     summary="Verifies if valid order ID",
   *     operationId="validate.order.for.id",
   *     produces={"application/json"},
   *     tags={"Order"},
   *    @SWG\Parameter(
   *         description="ID of specific order that needs to be verified",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Verifies if valid order ID",
   *         @SWG\Schema(ref="#/definitions/Order"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching order.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function orderIDExists(Request $request, $id){
    try{
        $statusCode = 200;
        $order = Order::findOrFail($id);
        $response = true;

     }catch (\Exception $e){
         $statusCode = 404;
         $response = false;
     }finally{
        //  return \Response::json($response, $statusCode);
         return $response;
     }
  }

  /**
   * Returns orders by order id
   * @Get("orders/{id}")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/orders/{id}",
   *     description="Returns an order based on a specific order ID",
   *     summary="Retrieve a specific existing order",
   *     operationId="get.order.for.id",
   *     produces={"application/json"},
   *     tags={"Order"},
   *    @SWG\Parameter(
   *         description="ID of specific order that needs to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve order based on a specific order ID",
   *         @SWG\Schema(ref="#/definitions/Order"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching order.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getOrdersById(Request $request, $id){
    try{
        $statusCode = 200;

        $order = Order::findOrFail($id);
        $order_items = OrderItem::where('order_id', $id)->get();
        $order->orderItems = $order_items;
        $response = $order;

     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching order"
             ]
         ];
     }finally{
      //  return \Response::json($response, $statusCode);
        return $response;
     }

  }

  /**
   * Returns orders by user id
   * @Get("user/{id}/orders")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/user/{id}/orders",
   *     description="Returns all orders based on a specific user ID",
   *     summary="Retrieve a existings order for user",
   *     operationId="get.orders.for.user.via.id",
   *     produces={"application/json"},
   *     tags={"Order"},
   *    @SWG\Parameter(
   *         description="ID of user for orders to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve order based on a specific user ID",
   *         @SWG\Schema(ref="#/definitions/Order"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching order.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getOrdersForUserById($id){
    try{
        $statusCode = 200;

        $response = Order::where('user_id', $id)->get();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching order"
             ]
         ];
     }finally{
         return \Response::json($response, $statusCode);
     }

  }

/**
  * Creates a new order
  * @Post("orders/add")
  *
  * @return \Illuminate\Http\Response
  *
  * @SWG\Post(
  *     path="/orders/add",
  *     description="Creates a new order",
  *     summary="Create a order",
  *     operationId="create.order",
  *     produces={"application/json"},
  *     consumes={"multipart/form-data"},
  *     tags={"Order"},
  *     @SWG\Parameter(
  *         description="Unique Id of user requesting an order",
  *         in="formData",
  *         name="userId",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Total amount of order",
  *         in="formData",
  *         name="amount",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Transaction Id assocaited with Stripe",
  *         in="formData",
  *         name="transactionId",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Response(
  *         response="200",
  *         description="Displays new order created",
  *         @SWG\Schema(ref="#/definitions/ErrorModel")
  *     ),
  *     @SWG\Response(
  *         response="404",
  *         description="Error creating order",
  *         @SWG\Schema(
  *             ref="#/definitions/ErrorModel"
  *         )
  *     )
  * )
  */
  public function addNewOrder(Request $request){
        try{
            $statusCode = 200;

            //Check if user id exists in request
            if(!$request->has('userId') || !User::where('id', $request->input('userId'))->exists()){
              throw new \Exception("User Id doesn't exist");
            }

            //Check if amount field exists in request
            if(!$request->has('amount')){
              throw new \Exception("Invalid amount parameter passed");
            }

            //Check if transaction exists in request
            if(!$request->has('transactionId') ||
            Order::where('stripe_transaction_id', $request->input('transactionId'))->exists()){
              throw new \Exception("Invalid transaction Id.");
            }

            //Create order
            $order = new Order();
            $order->total_paid = $request->input('amount');
            $order->user_id = $request->input('userId');
            $order->order_progress = 0;
            $order->delivered_by = Carbon::now()->addDays(7);
            $order->stripe_transaction_id = $request->input('transactionId');
            $order->save();

            $response = $order;

        }catch (\Exception $e){
            $statusCode = 200;
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
    * Creates a new order item
    * @Post("orders/{id}/add/{itemId}")
    *
    * @return \Illuminate\Http\Response
    *
    * @SWG\Post(
    *     path="/orders/{id}/add/{itemId}",
    *     description="Creates a new order item",
    *     summary="Creates a order item",
    *     operationId="create.order.item",
    *     produces={"application/json"},
    *     tags={"Order"},
    *    @SWG\Parameter(
    *         description="ID of specific order that needs to be retrieved",
    *         in="path",
    *         name="id",
    *         required=true,
    *         type="string"
    *     ),
    *    @SWG\Parameter(
    *         description="ID of specific product to be added to the order",
    *         in="path",
    *         name="itemId",
    *         required=true,
    *         type="string"
    *     ),
    *     @SWG\Response(
    *         response="201",
    *         description="List of order",
    *         @SWG\Schema(ref="#/definitions/OrderItem")
    *     ),
    *     @SWG\Response(
    *         response="404",
    *         description="Error creating order",
    *         @SWG\Schema(
    *             ref="#/definitions/ErrorModel"
    *         )
    *     )
    * )
    */
    public function addOrderItem($id, $itemId, $quantity){
       try{
           $statusCode = 200;

           if(!$id){
             throw new \Exception("No order id found");
           }

           $product = Product::findOrFail($itemId);

           if(!$itemId){
             throw new \Exception("Item doesn't exist in inventory");
           }

           $order_check = OrderItem::where('order_id', $id)->where('product_id', $itemId)->first();

           if($order_check){
             throw new \Exception("Error adding order of same type. Order already exists.");
           }

           $orderItem = new OrderItem();
           $orderItem->order_id = $id;
           $orderItem->product_id = $itemId;
           $orderItem->file_id = $product->file_id;
           $orderItem->quantity = $quantity;
           $orderItem->save();

           $response = $orderItem;
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
     * Delete order by id
     * @Delete("orders/{id}")
    *
    * @return \Illuminate\Http\Response
    *
    * @SWG\Delete(
    *     path="/orders/{id}",
    *     description="Deletes order based on a specific order ID",
    *     summary="Delete a specific existing order",
    *     operationId="delete.order.for.id",
    *     produces={"application/json"},
    *     tags={"Order"},
    *     @SWG\Parameter(
    *         description="ID of specific order that needs to be deleted",
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
    *         description="Error creating order",
    *         @SWG\Schema(
    *             ref="#/definitions/ErrorModel"
    *         )
    *     )
    * )
    */
    public function deleteOrderById($id){
          try{
              $statusCode = 204;
              Order::findOrFail($id)->delete();

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
       * Delete order item by id
       * @Delete("orders/{id}/delete")
      *
      * @return \Illuminate\Http\Response
      *
      * @SWG\Delete(
      *     path="/orders/{id}/delete",
      *     description="Deletes order item based on a specific ID",
      *     summary="Delete a specific existing order item",
      *     operationId="delete.order.item.for.id",
      *     produces={"application/json"},
      *     tags={"Order"},
      *     @SWG\Parameter(
      *         description="ID of specific order item that needs to be deleted",
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
      *         description="Error deleting order item",
      *         @SWG\Schema(
      *             ref="#/definitions/ErrorModel"
      *         )
      *     )
      * )
      */
      public function deleteOrderItemById(Request $request, $id){
          try{
              $statusCode = 200;

              $orderItem = OrderItem::findOrFail($id);
              $order_id = $orderItem->order_id;
              $orderItem->delete();

              //Destroy order if all items are deleted
              if (!OrderItem::where('order_id', $order_id)->exists()) {
                 Order::destroy($order_id);
              }

              $response = "Order item successfully deleted";

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

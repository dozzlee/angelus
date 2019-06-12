<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\ApiController;
// use Request;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Class ProductModule
 *
 * @Controller(prefix="v1/api")
 *
 * @package App\Http\Controllers\Api
 */
class ProductModule extends ApiController
{

  /**
   * Returns all products
   * @Get("products")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/products",
   *     description="Returns all products.",
   *     summary="Get all products",
   *     operationId="get.products",
   *     produces={"application/json"},
   *     tags={"Product"},
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve all products.",
   *         @SWG\Schema(ref="#/definitions/Product"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching products.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getProducts(){
    try{
        $statusCode = 200;
        $response = Product::all();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching product"
             ]
         ];
     }finally{
        //  return \Response::json($response, $statusCode);
        return $response;
     }

  }

  /**
   * Returns products by id
   * @Get("products/{id}")
   *
   * @return \Illuminate\Http\Response
   *
   * @SWG\Get(
   *     path="/products/{id}",
   *     description="Returns product based on a specific ID",
   *     summary="Retrieve a specific existing product",
   *     operationId="get.product.for.id",
   *     produces={"application/json"},
   *     tags={"Product"},
   *    @SWG\Parameter(
   *         description="ID of specific product that needs to be retrieved",
   *         in="path",
   *         name="id",
   *         required=true,
   *         type="string"
   *     ),
   *     @SWG\Response(
   *         response=200,
   *         description="Retrieve product based on a specific ID",
   *         @SWG\Schema(ref="#/definitions/Product"),
   *     ),
   *     @SWG\Response(
   *         response="404",
   *         description="Error fetching products.",
   *         @SWG\Schema(
   *             ref="#/definitions/ErrorModel"
   *         )
   *     )
   * )
   */
  public function getProductsById($id){
    try{
        $statusCode = 200;

        $response = Product::where('id', $id)->first();
     }catch (\Exception $e){
         $statusCode = 404;
         $response = [
             [
                 "code" => $statusCode,
                 "message" => "Error fetching product"
             ]
         ];
     }finally{
        //  return \Response::json($response, $statusCode);
         return $response;
     }

  }

/**
  * Creates a new product
  * @Post("products/add")
  *
  * @return \Illuminate\Http\Response
  *
  * @SWG\Post(
  *     path="/products/add",
  *     description="Creates a new product",
  *     summary="Create a product",
  *     operationId="create.product",
  *     produces={"application/json"},
  *     consumes={"multipart/form-data"},
  *     tags={"Product"},
  *     @SWG\Parameter(
  *         description="Name of product to be created",
  *         in="formData",
  *         name="name",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Product description",
  *         in="formData",
  *         name="description",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Price of product to be created",
  *         in="formData",
  *         name="price",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Image url of product to be created",
  *         in="formData",
  *         name="imageurl",
  *         required=true,
  *         type="string"
  *     ),
  *     @SWG\Parameter(
  *         description="Product image file to upload",
  *         in="formData",
  *         name="file",
  *         required=false,
  *         type="file"
  *     ),
  *     @SWG\Response(
  *         response="200",
  *         description="List of products",
  *         @SWG\Schema(ref="#/definitions/ErrorModel")
  *     ),
  *     @SWG\Response(
  *         response="404",
  *         description="Error creating product",
  *         @SWG\Schema(
  *             ref="#/definitions/ErrorModel"
  *         )
  *     )
  * )
  */
  public function addNewProduct(){
        try{
            $statusCode = 200;

            $file = \Illuminate\Support\Facades\Request::file('file');
            $extension = $file->getClientOriginalExtension();
            Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

            $entry = new \App\Models\File();
            $entry->mime = $file->getClientMimeType();
            $entry->original_filename = $file->getClientOriginalName();
            $entry->filename = $file->getFilename().'.'.$extension;
            $entry->save();

            $product  = new \App\Models\Product();
            $product->file_id = $entry->id;
            $product->name = \Illuminate\Support\Facades\Request::input('name');
            $product->description = \Illuminate\Support\Facades\Request::input('description');
            $product->price = \Illuminate\Support\Facades\Request::input('price');
            $product->price = \Illuminate\Support\Facades\Request::input('price');
            $saved = $product->save();
            $product->product_stock = \Illuminate\Support\Facades\Request::input('productStock');
            $product->imageurl = "/products/download/$product->id/$entry->filename";

            $response = $product->save() ? "Successfully added product." : "Error adding product.";

        }catch (Exception $e){
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
   * Delete product by id
   * @Delete("products/{id}")
  *
  * @return \Illuminate\Http\Response
  *
  * @SWG\Delete(
  *     path="/products/{id}",
  *     description="Deletes product based on a specific ID",
  *     summary="Delete a specific existing product",
  *     operationId="delete.product.for.id",
  *     produces={"application/json"},
  *     tags={"Product"},
  *     @SWG\Parameter(
  *         description="ID of specific product that needs to be deleted",
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
  *         description="Error creating product",
  *         @SWG\Schema(
  *             ref="#/definitions/ErrorModel"
  *         )
  *     )
  * )
  */
  public function deleteProductById($id){
        try{
            $statusCode = 204;
            Product::findOrFail($id)->delete();

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

}

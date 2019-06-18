<?php $__env->startSection('Admin shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container" style="margin-top:40px;">
        <?php if(session()->has('successful')): ?>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                  <div class="alert alert-success"><strong><?php echo e(session()->get('successful')); ?></strong></div>
              </div>
            </div>
        <?php endif; ?>
        <div class="row" style="margin-bottom:10px;">
            <div class="col-sm-6">
                <a href="/admin/product/new"><button class="btn btn-success pull-left accent-bg-5"><i class="fa fa-plus"></i> Add New Product</button></a>
            </div>
            <div class="col-sm-6">
                <a href="/admin/orders"><button class="btn btn-primary pull-right accent-bg-4">View Orders <i class="fa fa-arrow-right"></i></button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="item-list table table-striped" style="border:1px solid #ddd; margin-bottom:60px;">
                   <thead>
                      <tr>
                         <th>Product</th>
                         <th>Description</th>
                         <th>Price</th>
                         <th>In Stock</th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                     <?php foreach($products as $product): ?>
                     <form name="productinv-<?php echo e($product->id); ?>" method="POST" action="<?php echo e(route('cart-edit-item')); ?>" role="form">
                       <?php echo csrf_field(); ?>

                      <tr>
                         <td class="image hidden-xs"><img src="<?php echo e($product->imageurl); ?>" alt="<?php echo e($product->name); ?>"></td>
                         <td class="details">
                            <div class="clearfix">
                               <div class="pull-left no-float-xs">
                                  <a href="#" class="title"><?php echo e($product->name); ?></a>
                                  <div class="">
                                     <?php echo e($product->description); ?>

                                  </div>
                                  <span>Product Code: PID<?php echo e($product->id); ?></span>
                               </div>
                            </div>
                         </td>
                         <td class="unit-price hidden-xs"><span class="currency">$</span><?php echo e(number_format($product->price,2,'.','')); ?></td>
                         <td class="total-price accent-2"><span class="currency"></span><?php echo e($product->product_stock); ?></td>
                         <td class="qty">
                           <div class="action pull-right no-float-xs">
                              <div class="clearfix">
                                 <button data-toggle="modal" data-target="#myModal-<?php echo e($product->id); ?>" class="save" type="button"><i class="fa fa-edit"></i></button>
                                 <a href="/admin/product/destroy/<?php echo e($product->id); ?>" class="btn accent-bg-2 accent-0" style="height:30px;"><i class="fa fa-trash-o"></i></a>
                              </div>
                           </div>
                         </td>
                      </tr>
                      </form>

                      <!-- Modal -->
                      <div id="myModal-<?php echo e($product->id); ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header accent-bg-1">
                              <button type="button" class="close accent-0 accent-bg-0" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title accent-0"><i class="fa fa-edit"> Edit Product Information</i></h4>
                            </div>
                            <form name="editproduct-<?php echo e($product->id); ?>" method="POST" action="<?php echo e(route('product-edit-item')); ?>" role="form">
                              <?php echo csrf_field(); ?>

                              <div class="modal-body">
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group">
                                         <label>Product Name</label>
                                         <input type="text" value="<?php echo e($product->name); ?>" class="form-control" name="productName" placeholder="Edit Product Name">
                                      </div>
                                   </div>
                                   <div class="col-md-3">
                                      <div class="form-group">
                                         <label>Product Price</label>
                                         <input type="text" value="<?php echo e($product->price); ?>" class="form-control" name="productPrice" placeholder="Edit Product Price">
                                      </div>
                                   </div>
                                   <div class="col-md-3">
                                      <div class="form-group">
                                         <label>Product Stock</label>
                                         <input type="text" value="<?php echo e($product->product_stock); ?>" class="form-control" name="productStock" placeholder="Edit Product Stock">
                                      </div>
                                   </div>
                                   <div class="col-md-12">
                                      <div class="form-group">
                                         <label>Product Description</label>
                                         <textarea type="text" class="form-control" name="productDescription" placeholder="Edit Product Description">
                                            <?php echo e($product->description); ?>

                                         </textarea>
                                      </div>
                                   </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" value="<?php echo e($product->id); ?>" name="productId">
                                <button type="submit" class="btn btn-default accent-bg-5 accent-0">Save</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <?php endforeach; ?>
                   </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
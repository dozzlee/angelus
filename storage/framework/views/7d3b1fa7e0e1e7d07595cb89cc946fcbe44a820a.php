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
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <a href="/admin/products"><button class="btn btn-primary pull-right accent-bg-4">View Product Inventory <i class="fa fa-arrow-right"></i></button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <td>Order ID #</td>
                    <td>User ID #</td>
                    <td>Transaction ID #</td>
                    <td>($) Transaction Amount Total</td>
                    <td>Order status</td>
                    <td></td>
                    <td></td>
                    </thead>
                    <tbody>
                    <?php foreach($orders as $order): ?>
                      <form name="orderform-<?php echo e($order->id); ?>" method="POST" action="<?php echo e(route('order-edit-item')); ?>" role="form">
                        <?php echo csrf_field(); ?>

                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td><?php echo e($order->user_id); ?></td>
                            <td><?php echo e($order->stripe_transaction_id); ?></td>
                            <td>$<?php echo e(number_format($order->total_paid,2,'.','')); ?></td>
                            <td class="qty">
                               <?php echo Form::select('order_status', array('Accepted', 'In Progress', 'Shipped', 'Delivered', 'Completed'), $order->order_progress , array());; ?>

                               <input type="hidden" name="orderId" value="<?php echo e($order->id); ?>"/>
                            </td>
                            <td><a class="btn btn-primary accent-bg-3" href="/order/<?php echo e($order->id); ?>">View Items</a> </td>
                            <td class="details">
                              <div class="clearfix">
                                <div class="action pull-right no-float-xs">
                                   <div class="clearfix">
                                      <button class="save btn" type="submit"><i class="fa fa-save"></i></button>
                                      <a class="btn delete accent-0 accent-bg-2" href="/admin/order/destroy/<?php echo e($order->id); ?>"><i class="fa fa-trash-o"></i></a>
                                   </div>
                                </div>
                              </div>
                            </td>
                        </tr>
                      </form>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
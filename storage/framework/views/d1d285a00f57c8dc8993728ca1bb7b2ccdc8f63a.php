<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="update-nag">
              <div class="update-split accent-bg-6"><i class="fa fa-info"></i></div>
              <div class="update-text">Order ID #OID0000<?php echo e($order->id); ?> <a href="/tracking/<?php echo e($order->id); ?>" class="accent-2">Track order <i class="fa fa-arrow-right"></i></a> </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="cart">
           <table class="item-list">
              <thead>
                 <tr>
                    <th class="hidden-xs">Image</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th class="hidden-xs">Price</th>
                    <th>Total</th>
                 </tr>
              </thead>
              <tbody>
                <?php foreach($order->orderItems as $item): ?>
                 <tr>
                    <td class="image hidden-xs"><img src="/download/<?php echo e($order->id); ?>/<?php echo e($item->file->filename); ?>" alt="<?php echo e($item->product->name); ?>"></td>
                    <td class="details">
                       <div class="clearfix">
                          <div class="pull-left no-float-xs">
                             <a href="#" class="title"><?php echo e($item->product->name); ?></a>
                             <div class="">
                                <?php echo e($item->product->description); ?>

                             </div>
                             <span>Product Code: PID<?php echo e($item->product->id); ?></span>
                          </div>
                       </div>
                    </td>
                    <td class="unit-price hidden-xs"><span class="qty"></span><?php echo e($item->quantity); ?></td>
                    <td class="unit-price hidden-xs"><span class="currency">$</span><?php echo e(number_format($item->product->price,2,'.','')); ?></td>
                    <td class="total-price accent-2"><span class="currency">$</span><?php echo e(number_format($item->product->price * $item->quantity,2,'.','')); ?></td>
                 </tr>
                 <?php endforeach; ?>
              </tbody>
           </table>
           <table class="cart-summary">
              <tbody>
                 <tr>
                    <td style="width:100%;">
                    </td>
                    <td class="totals">
                       <table class="cart-totals">
                          <tbody>
                             <tr>
                                <td>Sub Total</td>
                                <td class="price">$<?php echo e(number_format($order->total_paid,2,'.','')); ?></td>
                             </tr>
                             <tr>
                                <td>Shipping</td>
                                <td class="price"><?php echo e(number_format(25,2,'.','')); ?></td>
                             </tr>
                             <tr>
                                <td class="cart-total">Total</td>
                                <td class="cart-total price accent-2">$<?php echo e(number_format($order->total_paid + 25,2,'.','')); ?></td>
                             </tr>
                          </tbody>
                       </table>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
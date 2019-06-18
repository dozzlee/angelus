<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="update-nag">
              <div class="update-split accent-bg-6"><i class="fa fa-info"></i></div>
              <div class="update-text">Order History Summary</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="cart">
            <table class="table table-striped item-list">
                <thead>
                <tr>
                    <th class="col-sm-2">Order ID #</th>
                    <th class="col-sm-4">Date Ordered</th>
                    <th class="col-sm-2"></th>
                </tr>
                </thead>
                <?php foreach($orders as $order): ?>
                    <tr>
                        <td>OID0000<?php echo e($order->id); ?></td>
                        <td><a href="/order/<?php echo e($order->id); ?>" style="font-size: 11px; color: #999;"> <?php echo e($order->created_at); ?></a></td>
                        <td><a href="/order/<?php echo e($order->id); ?>"><i class="fa fa-search-plus"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
          </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
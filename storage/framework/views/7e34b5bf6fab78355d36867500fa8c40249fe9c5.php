<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8">
            <h3>Order num : <?php echo e($order->id); ?></h3>
            <h3>Made on : <?php echo e($order->created_at); ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="col-sm-4">Name</th>
                    <th class="col-sm-4">File</th>
                    <th class="col-sm-2">Price</th>
                </tr>
                </thead>
                <?php foreach($order->orderItems as $item): ?>
                    <tr>
                        <td><?php echo e($item->product->name); ?></td>
                        <td><a href="/download/<?php echo e($order->id); ?>/<?php echo e($item->file->filename); ?>"> <?php echo e($item->file->filename); ?></a></td>
                        <td>$ <?php echo e(number_format($item->product->price,2,',','')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
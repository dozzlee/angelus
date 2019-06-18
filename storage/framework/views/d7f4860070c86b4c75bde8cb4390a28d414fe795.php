<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session()->has('successful')): ?>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="alert alert-success"><strong><?php echo e(session()->get('successful')); ?></strong></div>
      </div>
    </div>
<?php endif; ?>

<div class="row shop-tracking-status">

<?php /* Show $request errors after back-end validation */ ?>
<div class="col-md-12" style="margin-top:30px;">
    <?php if($errors->has()): ?>
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>The following errors occurred</h4>
            <ul>
                <?php foreach($errors->all() as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<div class="col-md-12">
    <div class="well">
      <h4 style="font-size:15px;font-weight:normal;">Track all order items.</h4>
      <?php echo Form::open(['url' => route('order-tracking'), 'data-parsley-validate', 'id' => 'tracking-form', 'name' => 'order-tracking-form']); ?>

        <div class="form-horizontal row">
          <div class="col-md-9" style="margin-left:20px;">
             <div class="form-group" id="trackingID">
                <?php echo Form::label('orderID', 'OrderID:'); ?>

                <?php echo Form::text('tracking_id', null, [
                    'class'                         => 'form-control',
                    'required'                      => 'required',
                    'data-parsley-required-message' => 'Order id is required',
                    'data-parsley-trigger'          => 'change focusout',
                    'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                    'data-parsley-minlength'        => '1',
                    'data-parsley-maxlength'        => '32',
                    'data-parsley-class-handler'    => '#order-id'
                    ]); ?>

             </div>
          </div>
          <div class="col-md-2" style="margin-top:25px;">
             <div class="form-group" id="">
               <?php echo Form::submit('Track Order', ['class' => 'btn btn-block btn-bigger btn-success', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']); ?>

             </div>
          </div>
        </div>
      <?php echo Form::close(); ?>


      <div class="order-status">
          <div class="order-status-timeline">
              <!-- class names: c0 c1 c2 c3 and c4 -->
              <div class="order-status-timeline-completion c<?php echo e($order->order_progress); ?>"></div>
          </div>

          <div class="image-order-status image-order-status-new active img-circle">
              <span class="status">Accepted</span>
              <div class="icon"></div>
          </div>
          <div class="image-order-status image-order-status-active active img-circle">
              <span class="status">In progress</span>
              <div class="icon"></div>
          </div>
          <div class="image-order-status image-order-status-intransit active img-circle">
              <span class="status">Shipped</span>
              <div class="icon"></div>
          </div>
          <div class="image-order-status image-order-status-delivered active img-circle">
              <span class="status">Delivered</span>
              <div class="icon"></div>
          </div>
          <div class="image-order-status image-order-status-completed active img-circle">
              <span class="status">Completed</span>
              <div class="icon"></div>
          </div>

      </div>

      <h4>Order summary:</h4>

      <ul class="list-group">
        <li class="list-group-item">
            <span class="prefix">Order ID:</span>
            <span class="label accent-1"><?php echo e($order->id); ?></span>
        </li>
          <li class="list-group-item">
              <span class="prefix">Date created:</span>
              <span class="label label-success"><?php echo e($order->created_at); ?></span>
          </li>
          <li class="list-group-item">
              <span class="prefix">Last update:</span>
              <span class="label label-success"><?php echo e($order->updated_at); ?></span>
          </li>
          <li class="list-group-item">
              <span class="prefix">Status:</span>
              <?php if($order->order_progress == 3): ?>
              <span class="accent-1">Your order has been delivered.</span>
              <?php else: ?>
              <span class="accent-1">Your order has been accepted and is being processed.</span>
              <?php endif; ?>
          </li>
      </ul>
    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
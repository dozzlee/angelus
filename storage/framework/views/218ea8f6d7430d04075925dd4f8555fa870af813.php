<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('includes.homeslider', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div id="shopper" class="">
      <div class="row">
        <div class="col-sm-12 padding-right">
          <div class="features_items">
            <h2 class="title text-center"> Product Items </h2>
          </div>
          <?php foreach($products as $product): ?>
              <div class="col-sm-5 col-md-3">
                <div class="thumbnail product">
                  <img src="<?php echo e($product->imageurl); ?>" class="img-responsive">
                  <div class="caption" style="text-align:center;">
                    <p style="font-weight: 400; color: #131416; margin: 0 0 10px 0;"><?php echo e($product->name); ?></p>
                    <p class="accent-2">$<?php echo e(number_format($product->price,2,'.','')); ?></p>
                    <p><a href="/product/<?php echo e($product->id); ?>" class="btn btn-product accent-bg-0 accent-0" role="button"><span class="fa fa-shopping-cart"></span> View</a> </p>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <script>
    /*price range*/
     $('#price-slider').slider();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
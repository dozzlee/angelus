<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <?php if(session()->has('successful')): ?>
              <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success"><strong><?php echo e(session()->get('successful')); ?></strong></div>
                </div>
              </div>
          <?php endif; ?>
          <div class="panel panel-default" >
                <div class="panel-heading accent-bg-1 accent-0">
                    <div class="panel-title" style="text-align:center;">Forgot Password</div>
                </div>
                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <form method="POST" action="<?php echo e(route('forgot-password')); ?>" class="form-horizontal" role="form">
                        <?php echo csrf_field(); ?>

                        <fieldset>
                          <span class="help-block">
                            <i class="fa fa-info"></i> Email address you use to log in to your account
                            <br>
                            We'll send you an email with instructions to choose a new password.
                          </span>
                          <div class="form-group input-group">
                            <span class="input-group-addon">
                              @
                            </span>
                            <input class="form-control" placeholder="Email" name="email" type="email" required="">
                          </div>
                          <button type="submit" class="btn btn-primary btn-block accent-bg-5">
                            Continue
                          </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
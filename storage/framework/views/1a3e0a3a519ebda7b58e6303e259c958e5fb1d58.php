<?php $__env->startSection('Admin shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container" style="margin-top:40px;">
        <?php if(session()->has('error')): ?>
            <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-warning"><strong><?php echo e(session()->get('error')); ?></strong></div>
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
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email Address</td>
                    <td>Phone Number</td>
                    <td>User Status</td>
                    <td></td>
                    <td></td>
                    </thead>
                    <tbody>
                    <?php foreach($users as $user): ?>
                      <form name="userform-<?php echo e($user->id); ?>" method="POST" action="<?php echo e(route('admin-profile-edit')); ?>" role="form">
                        <?php echo csrf_field(); ?>

                        <tr>
                            <td><?php echo e($user->first_name); ?></td>
                            <td><?php echo e($user->last_name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>+<?php echo e($user->phone_number); ?></td>
                            <td class="qty">
                               <?php echo Form::select('admin_status', array('Standard User', 'Super User'), $user->is_admin , array());; ?>

                               <input type="hidden" name="userID" value="<?php echo e($user->id); ?>"/>
                            </td>
                            <td class="details">
                              <div class="clearfix">
                                <div class="action pull-right no-float-xs">
                                   <div class="clearfix">
                                      <button class="save btn" type="submit"><i class="fa fa-save"></i></button>
                                      <a class="btn delete accent-0 accent-bg-2" href="/admin/user/destroy/<?php echo e($user->id); ?>"><i class="fa fa-trash-o"></i></a>
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
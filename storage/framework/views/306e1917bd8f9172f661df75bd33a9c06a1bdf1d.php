<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="margin-top:50px;">
    <div class="well row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="">
                <div class="row col-xs-12">
                    <div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h4>
                        <?php if($address): ?>
                        <small><cite title="San Francisco, USA"><?php echo e($address->address_line_1); ?>, <?php echo e($address->country); ?> <i class="fa fa-map-marker">
                        <?php endif; ?>
                        </i></cite></small>
                        <p class="profile-block">
                            <i class="fa fa-envelope"></i><?php echo e($user->email); ?>

                            <br />
                            <i class="fa fa-phone"></i>+<?php echo e($user->phone_number); ?>

                            <br />
                            <a class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> Edit Personal Information</a>
                          </p>

                          <!-- Modal -->
                          <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header accent-bg-1">
                                  <button type="button" class="close accent-0 accent-bg-0" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title accent-0" style="font-weight:bold;"><i class="fa fa-edit"> Edit Profile Information</i></h4>
                                </div>
                                <form name="editprofile" method="POST" action="<?php echo e(route('profile-edit')); ?>" role="form">
                                  <?php echo csrf_field(); ?>

                                  <div class="modal-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>First Name</label>
                                             <input type="text" value="<?php echo e($user->first_name); ?>" class="form-control" name="firstName" placeholder="Edit First Name">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Last Name</label>
                                             <input type="text" value="<?php echo e($user->last_name); ?>" class="form-control" name="lastName" placeholder="Edit Last Name">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Email Address</label>
                                             <input type="text" value="<?php echo e($user->email); ?>" class="form-control" name="email" placeholder="Edit Email Address">
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <label>Phone Number</label>
                                             <input type="text" value="<?php echo e($user->phone_number); ?>" class="form-control" name="phoneNumber" placeholder="Edit Phone Number">
                                          </div>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="modal-footer">
                                    <input type="hidden" value="<?php echo e($user->id); ?>" name="userID">
                                    <button type="submit" class="btn btn-default accent-bg-5 accent-0">Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
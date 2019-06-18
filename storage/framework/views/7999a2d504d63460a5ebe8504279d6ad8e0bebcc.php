<?php $__env->startSection('Digital shop', 'Page Title'); ?>

<?php $__env->startSection('sidebar'); ?>
    @parent
<?php $__env->stopSection(); ?>

<?php $countries = app('App\Http\Utilities\Country'); ?>
<?php $states = app('App\Http\Utilities\State'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session()->has('successful')): ?>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="alert alert-success"><strong><?php echo e(session()->get('successful')); ?></strong></div>
      </div>
    </div>
<?php endif; ?>
<div class="row checkout-panel">
  <?php echo Form::open(['url' => route('order-checkout'), 'data-parsley-validate', 'id' => 'payment-form', 'name' => 'stripe-payment-form']); ?>

  <div class="col-md-9">
    <div class="panel-group checkout" id="accordion">
      <div class="panel panel-default">
         <div class="panel-heading heading-iconed">
            <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
               <i class="icon-left"><i class="fa fa-map-marker"></i></i> Shipping Information
               </a>
            </h4>
         </div>
         <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <?php echo Form::label('firstName', 'First Name'); ?>

                           <?php echo Form::text('first_name', 'Enter First Name', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-required-message' => 'First name is required',
                               'data-parsley-trigger'          => 'change focusout',
                               'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                               'data-parsley-minlength'        => '2',
                               'data-parsley-maxlength'        => '32',
                               'data-parsley-class-handler'    => '#first-name-group'
                               ]); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <?php echo Form::label('lastName', 'Last Name'); ?>

                           <?php echo Form::text('last_name', 'Enter Last Name', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-required-message' => 'Last name is required',
                               'data-parsley-trigger'          => 'change focusout',
                               'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                               'data-parsley-minlength'        => '2',
                               'data-parsley-maxlength'        => '32',
                               'data-parsley-class-handler'    => '#last-name-group'
                               ]); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <?php echo Form::label('country', 'Country'); ?>

                          <?php echo Form::select('country', array_flip($countries->all()), Input::old('state'), [
                              'class'       => 'form-control',
                              'required'                      => 'required',
                              'data-parsley-required-message' => 'State is required',
                              'data-parsley-trigger'          => 'change focusout',
                              ]); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <?php echo Form::label('state', 'State'); ?>

                          <?php echo Form::select('state', $states->all(), Input::old('state'), [
                          'class'       => 'form-control',
                          'required'                      => 'required',
                          'data-parsley-required-message' => 'State is required',
                          'data-parsley-trigger'          => 'change focusout',
                          ]); ?>

                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <?php echo Form::label('phone_number', 'Phone Number'); ?>

                           <?php echo Form::text('phone_number', 'Enter Phone Number (Eg: 1234567890)', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-type'             => 'number',
                               'data-parsley-trigger'          => 'change focusout',
                               'maxlength'                     => '5'
                               ]); ?>

                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="form-group">
                           <?php echo Form::label('zip_code', 'Zip Code'); ?>

                           <?php echo Form::text('zip_code', 'Enter Zip Code', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-type'             => 'number',
                               'data-parsley-trigger'          => 'change focusout',
                               'maxlength'                     => '5'
                               ]); ?>

                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <?php echo Form::label('address_line', 'Address Line 1'); ?>

                     <?php echo Form::text('address_line', 'Enter Address Line 1', [
                         'class'                         => 'form-control',
                         'required'                      => 'required',
                         'data-parsley-required-message' => 'Address Line 1 is required',
                         'data-parsley-trigger'          => 'change focusout',
                         'data-parsley-minlength'        => '5',
                         'data-parsley-maxlength'        => '255'
                         ]); ?>

                  </div>
                  <div class="form-group">
                    <?php echo Form::label('address_line2', 'Address Line 2'); ?>

                    <?php echo Form::text('address_line2', 'Enter Address Line 2', [
                        'class'                         => 'form-control',
                        'data-parsley-trigger'          => 'change focusout'
                        ]); ?>

                  </div>
            </div>
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading heading-iconed">
            <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
               <i class="icon-left"><i class="fa fa-credit-card"></i></i> Payment Information
               </a>
            </h4>
         </div>
         <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
               <p>Please fill in payment details.</p>
               <hr>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group" id="first-name-group">
                        <?php echo Form::label('firstName', 'First Name:'); ?>

                        <?php echo Form::text('first_name', null, [
                            'class'                         => 'form-control stripe_first_name',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'First name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32',
                            'data-parsley-class-handler'    => '#first-name-group'
                            ]); ?>

                     </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="last-name-group">
                        <?php echo Form::label('lastName', 'Last Name:'); ?>

                        <?php echo Form::text('last_name', null, [
                            'class'                         => 'form-control stripe_last_name',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'Last name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32',
                            'data-parsley-class-handler'    => '#last-name-group'
                            ]); ?>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="cc-group">
                        <?php echo Form::label(null, 'Credit card number:'); ?>

                        <?php echo Form::text(null, null, [
                            'class'                         => 'form-control',
                            'required'                      => 'required',
                            'data-stripe'                   => 'number',
                            'data-parsley-type'             => 'number',
                            'maxlength'                     => '16',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-class-handler'    => '#cc-group'
                            ]); ?>

                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="email-group">
                        <?php echo Form::label('email', 'Email address:'); ?>

                        <?php echo Form::email('email', null, [
                            'class' => 'form-control',
                            'placeholder'                   => 'email@example.com',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'Email name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-class-handler'    => '#email-group'
                            ]); ?>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="exp-m-group">
                        <?php echo Form::label(null, 'Ex. Month'); ?>

                        <?php echo Form::selectMonth(null, null, [
                            'class'                 => 'form-control',
                            'required'              => 'required',
                            'data-stripe'           => 'exp-month'
                        ], '%m'); ?>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="exp-y-group">
                        <?php echo Form::label(null, 'Ex. Year'); ?>

                        <?php echo Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                            'class'             => 'form-control',
                            'required'          => 'required',
                            'data-stripe'       => 'exp-year'
                            ]); ?>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="ccv-group">
                        <?php echo Form::label(null, 'Card Validation Code (3 or 4 digit number):'); ?>

                        <?php echo Form::text(null, null, [
                            'class'                         => 'form-control',
                            'required'                      => 'required',
                            'data-stripe'                   => 'cvc',
                            'data-parsley-type'             => 'number',
                            'data-parsley-trigger'          => 'change focusout',
                            'maxlength'                     => '4',
                            'data-parsley-class-handler'    => '#ccv-group'
                            ]); ?>

                    </div>
                  </div>
               </div>
               <hr>

               <div class="row">
                 <div class="col-md-12">
                     <span class="payment-errors" style="color: red;margin-top:10px;"></span>
                 </div>
               </div>
            </div>
         </div>
      </div>
      </div>
  </div>
  <div class="col-md-3">
    <div class="checkout-summary">
      <table>
        <tbody>
          <tr>
            <td>(<?php echo e($quantity); ?>) Items</td>
            <td class="price">$<?php echo e(number_format($total,2,'.','')); ?></td>
          </tr>
          <tr>
            <td>Standard Shipping Price</td>
            <td class="price"><span class="success">$<?php echo e(number_format(25,2,'.','')); ?></span></td>
          </tr>
          <tr class="total">
            <td> Total </td>
            <?php if($total): ?>
            <td class="price accent-2">$<?php echo e(number_format($total + 25,2,'.','')); ?></td>
            <?php else: ?>
            <td class="price accent-2">$<?php echo e(number_format($total,2,'.','')); ?></td>
            <?php endif; ?>
          </tr>
        </tbody>
      </table>
      <a href="/cart" class="btn btn-block btn-bigger accent-0 accent-bg-1">View Cart</a>
      <?php echo Form::submit('Checkout', ['class' => 'btn btn-block btn-bigger accent-0 accent-bg-2', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']); ?>

    </div>
  </div>
  <?php echo Form::close(); ?>


  <?php /* Show $request errors after back-end validation */ ?>
  <div class="col-md-6 col-md-offset-3">
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
</div>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
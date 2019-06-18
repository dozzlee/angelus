<!doctype html>

<html lang="en">

<head>
  <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>

<body>
    <section>
      <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>

    <section>
      <div class="container-fluid">
          <?php echo $__env->yieldContent('content'); ?>
      </div>
    </section>

<!-- PARSLEY -->
<script>
    window.ParsleyConfig = {
        errorsWrapper: '<div></div>',
        errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
        errorClass: 'has-error',
        successClass: 'has-success'
    };
</script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>

<!-- Inlude Stripe.js -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('<?php echo env('STRIPE_KEY'); ?>');

    jQuery(function($) {
        $('#payment-form').submit(function(event) {
            var $form = $(this);
            var accountName = $('.stripe_first_name').val() + " " + $('.stripe_last_name').val();

            //Account Name
            addFormField($form, 'name', accountName);

            // Before passing data to Stripe, trigger Parsley Client side validation
            $form.parsley().subscribe('parsley:form:validate', function(formInstance) {
                formInstance.submitEvent.preventDefault();
                return false;
            });

            // Disable the submit button to prevent repeated clicks
            $form.find('#submitBtn').prop('disabled', true);

            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from submitting with the default action
            return false;
        });
    });

    function stripeResponseHandler(status, response) {
        var $form = $('#payment-form');

        if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').addClass('alert alert-danger');
            $form.find('#submitBtn').prop('disabled', false);
            $('#submitBtn').button('reset');
        } else {
            // response contains id and card, which contains additional card details
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // and submit
            $form.get(0).submit();
        }
    };

    function addFormField(formInstance, key, value) {

        // Create a hidden input element, and append it to the form:
        var input = document.createElement('input');
        input.type = 'hidden';
        input.setAttribute('data-stripe', 'name');
        input.value = value;
        formInstance.append(input);
    };
</script>
</body>
</html>

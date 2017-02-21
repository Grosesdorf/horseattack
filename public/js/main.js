function reportError(msg) {
    // Show the error in the form:
    $('#paymentErrors').text(msg).addClass('alert alert-danger');
    // re-enable the submit button:
    $('#submitStripe').prop('disabled', false);
    return false;
}

$(document).ready(function() {

     Stripe.setPublishableKey('pk_test_t9LfL4nE4hH7owXEbgO2u4CJ');

    // STRIPE
    // Watch for a form submission:
    $("#stripeForm").submit(function(event) {
        // Flag variable
        var error = false;
        // disable the submit button to prevent repeated clicks
        $('#submitStripe').attr('disabled', 'disabled');
 
    // Get the values:
    var ccNum = $('#cardNumber').val(),
        cvcNum = $('#cardCCV').val(),
        expMonth = $('#cardMM').val(),
        expYear = $('#cardYY').val();
    // Validate the number:
    if (!Stripe.card.validateCardNumber(ccNum)) {
        error = true;
        reportError('The credit card number appears to be invalid.');
    }
    // Validate the CVC:
    if (!Stripe.card.validateCVC(cvcNum)) {
        error = true;
        reportError('The CVC number appears to be invalid.');
    }
    // Validate the expiration:
    if (!Stripe.card.validateExpiry(expMonth, expYear)) {
        error = true;
        reportError('The expiration date appears to be invalid.');
    }

            // Validate other form elements, if needed!

        // Check for errors:
    
    if (!error) {
    // Get the Stripe token:
    Stripe.card.createToken({
        number: ccNum,
        cvc: cvcNum,
        exp_month: expMonth,
        exp_year: expYear
        }, 
        stripeResponseHandler);
    }
            // Prevent the form from submitting:
        return false;

    }); // Form submission

    // body background-image
    var bodyPathImg = $('#selectTheme').attr('data-path-img');
    $('body').css('backgroundImage', 'url('+bodyPathImg+')');

    $( "#selectTheme" ).change(function() {
        // $urlSite = location.hostname;
        // location = $urlSite+'/showplan/'+$('#selectTheme').val();
        location = '/showplan/'+$('#selectTheme').val();
    });

    $('#stripeButton').attr('data-amount', function(event) {
        return parseFloat($("select#selectPlan").val()) * 100;
    });

    $( "#selectPlan" ).change(function() {
        $('#stripeButton').attr('data-amount', function(event) {
            return parseFloat($("select#selectPlan").val()) * 100;
        });
    });

    //PayPal
    // window.paypalCheckoutReady = function () {
    //  paypal.checkout.setup('grosesdorf-facilitator_api1.gmail.com', {
    //      container: 'myContainer', //{String|HTMLElement|Array} where you want the PayPal button to reside
    //      environment: 'sandbox' //or 'production' depending on your environment
    //  });
    // };

    // paypal.Button.render({
    
    //     // env: 'production', // Specify 'sandbox' for the test environment
    //     env: 'sandbox', // Specify 'sandbox' for the test environment

    //     style: {
    //         size: 'medium',
    //         color: 'blue',
    //         shape: 'rect'
    //     },

    //     // commit: true, // Optional: show a 'Pay Now' button in the checkout flow

    //     client: {
    //         sandbox:    'grosesdorf-facilitator_api1.gmail.com',
    //         // production: 'xxxxxxxxx'
    //     },

    //     payment: function(resolve, reject) {
               
    //         // var CREATE_PAYMENT_URL = 'https://my-store.com/paypal/create-payment';
    //         var CREATE_PAYMENT_URL = 'http://someattack.local/paypal';
                
    //         paypal.request.post(CREATE_PAYMENT_URL)
    //             .then(function(data) { resolve(data.paymentID); })
    //             .catch(function(err) { reject(err); });
    //     },

    //     onAuthorize: function(data) {
        
    //         // Note: you can display a confirmation page before executing
            
    //         var EXECUTE_PAYMENT_URL = 'http://someattack.local/paypal';

    //         paypal.request.post(EXECUTE_PAYMENT_URL,
    //                 { paymentID: data.paymentID, payerID: data.payerID })
                    
    //             .then(function(data) { /* Go to a success page */ })
    //             .catch(function(err) { /* Go to an error page  */ });
    //     },

    //     onCancel: function(data, actions) {
    //         // Show a cancel page or return to cart
    //         return actions.redirect();
    //     },
            
    // }, '#paypal-button');


});

function stripeResponseHandler(status, response) {

    // Check for an error:
    if (response.error) {

        reportError(response.error.message);

    } else { // No errors, submit the form:

      var f = $("#stripeForm");

      // Token contains id, last4, and card type:
      var token = response['id'];

      // Insert the token into the form so it gets submitted to the server
      f.append("<input type='hidden' name='stripeToken' value='" + token + "' />");

      // Submit the form:
      f.get(0).submit();

    }

} // End of stripeResponseHandler() function.


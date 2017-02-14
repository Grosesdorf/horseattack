$(document).ready(function() {
    $('#stripeButton').on('click', function(event) {
        event.preventDefault();
        var $button = $(this),
            $form = $button.parents('form');
        var opts = $.extend({}, $button.data(), {
            token: function(result) {
                $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
            }
        });
        StripeCheckout.open(opts);
    });

    $('#stripeButton').attr('data-amount', function(event) {
        return parseFloat($("select#selectPlan").val()) * 100;
    });

    $( "#selectPlan" ).change(function() {
        $('#stripeButton').attr('data-amount', function(event) {
            return parseFloat($("select#selectPlan").val()) * 100;
        });
    });
});
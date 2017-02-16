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
});
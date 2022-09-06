<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
    $('#cancelBtn').click(function (e) {
        e.preventDefault();
        $('.errortext').addClass('hide');
        $('#payment-form').trigger("reset");
        $('#myModal').modal('close');
        
    });
    $('body').on('click', '#editPayment', function (e) {
        $('#myModal').modal()[0].M_Modal.options.dismissible = false;
        $('#myModal').modal('open');
        $('#cardnumber').focus();
    });

    $('#payment-form').bind('submit', function(e) {
        $form = $('#payment-form');
        e.preventDefault();
        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
    });

    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.errortext')
                .removeClass('hide')
                .find('#errortext')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $('#stripeToken').val(token);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                data: $('#payment-form').serialize(),
                url: "{{ route('user.setPayment') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $(".errortext").html('');
                    $('.errortext').addClass('hide');
                    // $('#expensetype').val($("#expensetype option:first").val()).change();
                    $('#payment-form').trigger("reset");
                    $('#myModal').modal('close');
                    $('#lastfour').text('****'+data['lastfour']);
                    M.toast({
                        html: data['success'],
                        classes: 'rounded'
                    });
                },
                error: function (data) {
                }
            });
        }
    }
</script>
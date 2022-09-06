/* Preloader Js
    ===================*/
    $(window).on("load", function () {
        $('.preloader').fadeOut(500);
        $('.progress').fadeOut(1000);
        /*WoW js Active
        =================*/
        new WOW().init({
            mobile: false,
        });
    });

    // $('.loader-wrapper').fadeOut('3000', function() {
    //     $(this).remove();
    // });
    
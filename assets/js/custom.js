(function($){
    $(function(){

        $('.button-collapse').sideNav();
        $('.modal').modal({
            dismissible: false
        });
        $('select').material_select();
        $('.collapsible').collapsible();
        // $('.tooltipped').tooltip({delay: 50});

        //Preloader
        $(window).load(function () {
            $('.preloader-box').fadeOut('slow', function () {
                $(this).remove();
            });
        });

    });
})(jQuery);


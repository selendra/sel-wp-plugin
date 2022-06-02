jQuery(document).ready(function ($) {
    $(".button-type").click(function () {
        var btnType = $(this).attr('id');
        if (btnType == 'with-email') {
            $("#login").show();
            $(".phone-login").hide();
        } else {
            $("#login").hide();
            $(".phone-login").show();
        }
        $(".button-type").removeClass("active");
        $(this).addClass("active");
    });
});
function logout(user ) {

    jQuery.ajax({
        type: 'POST',
        url: ajax_object.ajax_url,
        data: {
            'action': 'custom_ajax_logout', //calls wp_ajax_nopriv_ajaxlogout
            'ajaxsecurity': ajax_object.logout_nonce
        },
        success: function(r){
            // When the response comes back
            window.location = ajax_object.home_url;
        }
    });

}

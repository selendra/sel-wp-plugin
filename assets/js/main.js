jQuery(document).ready(function ($) {
    if ($(".language-switcher")) {
        var ele = $('.language-switcher').detach();
        $('.login').append(ele);
    }
});
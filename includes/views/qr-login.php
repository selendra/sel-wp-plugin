<div class="basis-2/5 sm:ml-16 md:ml-16  flex flex-col items-center self-center">
    <figure class="figure">
        <img class="img-responsive dark:invert" src="<?php echo SEL_WP_LOGIN_PLUGIN_PATH . 'assets/img/qr_code.png' ?>" style="width:200px;">
    </figure>
    <p class="text-center mb-4 text-lg font-light dark:text-white"><strong><?php _e('Log in with QR code', 'sel-wp-login'); ?></strong></p>
    <p class="text-center text-sm dark:text-slate-400">
        <?php _e('Scan this code with the', 'sel-wp-login'); ?>
        <a href="#" class="text-sky-500 no-underline font-medium text-sm">
            <?php _e('Bitriel mobile
            app', 'sel-wp-login'); ?>
        </a>
        <?php _e('to log in instantly.', 'sel-wp-login'); ?>
    </p>
</div>
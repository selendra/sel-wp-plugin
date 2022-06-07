<div class="wrap">
    <h1><?php _e('Seldendra WP Login Settings', 'sel-wp-login') ?></h1>
    <form method="POST" action="options.php">
        <?php
        settings_fields('sel_wp_login_page');
        do_settings_sections('sel_wp_login_page');
        submit_button();
        ?>
    </form>
</div>
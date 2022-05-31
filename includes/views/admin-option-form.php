<div class="wrap">
    <h1><?php echo esc_html_e('Seldendra WP Login Settings', 'sel_wp_login') ?></h1>
    <form method="POST" action="options.php">
        <?php
        settings_fields('sel_wp_login_page');
        do_settings_sections('sel_wp_login_page');
        submit_button();
        ?>
    </form>
</div>
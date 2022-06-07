<?php
$custom_logo_id = get_theme_mod('custom_logo');
$image = wp_get_attachment_image_src($custom_logo_id, 'full');
?>
<nav>
    <div class="relative flex justify-center h-16 my-2">
        <button type="button" class="sm:mr-4">
            <span class="sr-only">Website Logo</span>
            <?php if (isset($image[0])) : ?>
                <img class='object-contain h-16' src='<?php echo $image[0]; ?>'>
            <?php else : ?>
                <span class="text-xl text-black dark:text-white"><?php echo get_bloginfo('name'); ?></span>
            <?php endif; ?>
        </button>
        <div class="w-5/12 md:w-4/12"></div>
        <button type="button" class="sm:ml-4" onclick="toggleDarkMode();">
            <span class="sr-only">Switch Theme</span>
            <img class='object-contain h-12 dark:invert origin-bottom -scale-x-100' src='<?php echo SEL_WP_LOGIN_PLUGIN_PATH . 'assets/img/cloud-moon.svg' ?>'>
        </button>
    </div>

</nav>
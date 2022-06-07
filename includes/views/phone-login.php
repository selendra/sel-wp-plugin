<?php
$is_forget_password_page = Sel_WP_Login::instance()->is_forget_password_page();
$is_register_page = Sel_WP_Login::instance()->is_register_page();
?>
<div class="hidden phone-login flex flex-col mt-4 mb-4" id="tab-phone">
    <form id="loginform" class="bg-transparent">
        <div class="flex flex-col">
            <div class="w-full">
                <label for="user_phone"><?php _e('Username or Email Address'); ?> </label>
            </div>
            <div class="flex flex-row">
                <div class="basis-1/3 mt-2 cursor-pointer">
                    <div class="dropbtn flex flex-row items-center"></div>
                    <div style="overflow: hidden;">
                        <div id="myDropdown" class="dropdown-content">
                        </div>
                    </div>
                </div>
                <div class="basis-2/3">
                    <input type="tel" id="user_phone" class="w-full" value="" size="20">
                </div>
            </div>

        </div>
        <?php if (!$is_forget_password_page) : ?>
            <div class="user-pass-wrap mt-4">
                <label for="user_pass"><?php _e('Password', 'sel-wp-login'); ?></label>
                <div class="wp-pwd">
                    <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20" autocomplete="current-password">
                    <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Show password">
                        <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <label for="rememberme"><?php _e('Remember Me') ?> </label></p>
        <?php else : ?>
            <div class="mt-4"></div>
        <?php endif; ?>

        <p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php if ($is_forget_password_page) : _e('Get New Password');
                                                                                                                    elseif ($is_register_page) : _e('Register');
                                                                                                                    else : _e('Log In');
                                                                                                                    endif; ?>">
            <input type="hidden" name="redirect_to" value="http://localhost:8888/test-plugin/wp-admin/">
            <input type="hidden" name="testcookie" value="1">
        </p>
        <p id="phone-login-nav">
            <?php
            $is_can_register = get_option('users_can_register');
            $register_url = sprintf('<a class="mt-5 mb-3 text-black dark:text-white" href="%s">%s</a>', esc_url(wp_registration_url()), __('Register'));
            $lostpassword_url =  sprintf('<a class="mt-2 text-black dark:text-white" href="%s">%s</a>', esc_url(wp_lostpassword_url()), __('Lost your password?'));
            $login_url = sprintf('<a class="mt-5 mb-3 text-black dark:text-white" href="%s">%s</a>', esc_url(wp_login_url()), __('Log in'));
            if ($is_register_page) {
                echo $lostpassword_url;
                echo $login_url;
            } else if ($is_forget_password_page) {
                if ($is_can_register) echo $register_url;
                echo $login_url;
            } else {
                echo $lostpassword_url;
                if ($is_can_register) echo $register_url;
            }

            ?>
        </p>
        <p id="mybacktoblog" class="text-black dark:text-white">
            <a href="http://localhost:8888/test-plugin/">← Go to Test Plugin</a>
        </p>
    </form>
</div>
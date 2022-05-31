<?php
$is_forget_password_page = Sel_WP_Login::instance()->is_forget_password_page();
$is_register_page = Sel_WP_Login::instance()->is_register_page();
?>
<div class="phone-login">
    <form id="loginform">
        <div class='row' style="justify-content: space-between;">
            <div style="width:100%;">
                <label for="user_phone"><?php esc_html_e('Phone Number', SEL_WP_LOGIN_KEY_NAME); ?> </label>
            </div>
            <div class='prefix-phone'>
                <div class="dropbtn"></div>
                <div style=" overflow: hidden;">
                    <div id="myDropdown" class="dropdown-content">
                    </div>
                </div>
            </div>
            <div class="phone-number">
                <input type="text" id="user_phone" class="input" value="" size="20">
            </div>
        </div>
        <?php if (!$is_forget_password_page) : ?>
            <div class="user-pass-wrap">
                <label for="user_pass"><?php esc_html_e('Password', SEL_WP_LOGIN_KEY_NAME); ?></label>
                <div class="wp-pwd">
                    <input type="password" name="pwd" id="user_pass" class="input password-input" value="" size="20" autocomplete="current-password">
                    <button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Show password">
                        <span class="dashicons dashicons-visibility" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php if ($is_forget_password_page) : ?>Get New Password<?php elseif ($is_register_page) : ?>Register<?php else : ?>  Log In <?php endif; ?>">
            <input type="hidden" name="redirect_to" value="http://localhost:8888/test-plugin/wp-admin/">
            <input type="hidden" name="testcookie" value="1">
        </p>
        <p id="phone-login-nav">
            <a href="http://localhost:8888/test-plugin/wp-login.php?action=lostpassword">Lost your password?</a>
            <a href="http://localhost:8888/test-plugin/wp-login.php?action=register">Register</a>
        </p>
        <p id="backtoblog">
            <a href="http://localhost:8888/test-plugin/">← Go to Test Plugin</a>
        </p>
    </form>
</div>
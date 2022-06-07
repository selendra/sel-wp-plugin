<?php
/**
 * @package Selendra WP Login
 */
/*
Plugin Name: Selendra WP Login
Plugin URI:
Description: This is Selendra WP Login Plugin to enable user login to work with Selendra ID App.
Version: 1.0.0
Author: Sothy SEK
Author URI:
License: GPLv2 or later
Text Domain: sel-wp-login
Domain Path: /languages
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

//Don't allow called directly
if (!defined('ABSPATH') || !function_exists('add_action')) {
    exit;
}
define("SEL_WP_LOGIN_KEY_NAME", 'sel_wp_login');
define('SEL_WP_LOGIN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SEL_WP_LOGIN_PLUGIN_PATH', plugin_dir_url(__FILE__));
require_once(SEL_WP_LOGIN_PLUGIN_DIR . 'includes/class-sel-wp-login.php');
require_once(SEL_WP_LOGIN_PLUGIN_DIR . 'includes/class-sel-wp-login-css.php');

function sel_wp_login()
{
    $instance = Sel_WP_Login::instance(SEL_WP_LOGIN_PLUGIN_DIR, '1.0.0');
    return $instance;
}
sel_wp_login();

<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://sniperpress.com
 * @since             1.0.0
 * @package           sniperpress_mail
 *
 * @wordpress-plugin
 * Plugin Name:       SniperPress Mail
 * Plugin URI:        http://sniperpress.com/sniperpressmail
 * Description:		  Email Marketing Automation With 3rd Party Services
 * Version:           1.0.0
 * Author:            SniperPress
 * Author URI:        http://sniperpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sniperpress-mail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sniperpress-mail-activator.php
 */
function activate_sniperpress_mail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sniperpress-mail-activator.php';
	sniperpress_mail_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sniperpress-mail-deactivator.php
 */
function deactivate_sniperpress_mail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sniperpress-mail-deactivator.php';
	sniperpress_mail_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sniperpress_mail' );
register_deactivation_hook( __FILE__, 'deactivate_sniperpress_mail' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sniperpress-mail.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sniperpress_mail() {

	$plugin = new sniperpress_mail();
	$plugin->run();

}
run_sniperpress_mail();

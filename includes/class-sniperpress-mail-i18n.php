<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://sniperpress.com 
 * @since      1.0.0
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/includes
 * @author     SniperPress <sniperpressmail@sniperpress.com>
 */
class sniperpress_mail_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sniperpress-mail',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

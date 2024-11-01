<?php

/**
 * Fired during plugin activation
 *
 * @link       http://sniperpress.com
 * @since      1.0.0
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/includes
 * @author     SniperPress <sniperpressmail@sniperpress.com>
 */
class sniperpress_mail_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		update_option( 'wpsm_settings', array('getresponse'=>'','mailchimp'=>'') );

	}

}

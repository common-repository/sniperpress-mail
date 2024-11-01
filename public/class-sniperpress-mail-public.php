<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://sniperpress.com
 * @since      1.0.0
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/public
 * @author     SniperPress <sniperpressmail@sniperpress.com>
 */
class sniperpress_mail_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in sniperpress_mail_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The sniperpress_mail_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sniperpress-mail-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in sniperpress_mail_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The sniperpress_mail_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sniperpress-mail-public.js', array( 'jquery' ), $this->version, false );

	}


  public function wpsm_call_action ($service_provider, $action_id, $user_info, $list_id) {

		// calls the right callback funcion

		// if the service is getresponse, calls the action_callback of the action
	 	if ($service_provider == 'getresponse') {
			switch ($action_id)	{
				case 'add_to_list':
					$wpsm_email_class=new sniperpress_mail_GetResponse();
					$wpsm_email_class->add_to_list($user_info,$list_id);
					break;
				case 'remove_from_list':
					$wpsm_email_class=new sniperpress_mail_GetResponse();
					$wpsm_email_class->remove_from_list($user_info,$list_id);
					break;
			}
		};

		if ($service_provider == 'mailchimp') {
			// calls the right callback funcion
			switch ($action_id)	{
				case 'add_to_list':
					$wpsm_email_class=new sniperpress_mail_MailChimp();
					$wpsm_email_class->add_to_list($user_info,$list_id);
					break;
			case 'remove_from_list':
					$wpsm_email_class=new sniperpress_mail_MailChimp();
					$wpsm_email_class->remove_from_list($user_info,$list_id);
					break;
			}

		};

	}

	public function wpsm_user_register( $user_id ) {
		//	Runs the USER REGISTER HOOK

		// get active rules
		$wpsm_rules = get_option('wpsm_rules');

		// Finds user_register hook inside the rules
		foreach($wpsm_rules as $key => $wpsm_rule_temp)	{

			// Finds the hook in rules
		 	if ( $wpsm_rule_temp['hook_id'] === 'user_register' )	{

				$user_info=get_userdata($user_id);	// get new user data
				$this->wpsm_call_action($wpsm_rule_temp['service_provider'],$wpsm_rule_temp['action_id'], $user_info, $wpsm_rule_temp['list_id']);

			}
		}
	}

	public function wpsm_user_comment( $comment_ID, $comment_approved, $commentdata ) {
	/**
		*		Runs the USER COMMENT HOOK
		*		If the user is not logged in, creates a temporary class with email and author name and runs the actions
		*		If the user is logged in calls the WP_User object
	**/

			// get active rules
			$wpsm_rules = get_option('wpsm_rules');

			// Finds user_register hook inside the rules
			foreach($wpsm_rules as $key => $wpsm_rule_temp) {

				// Finds the hook in rules
				if ( $wpsm_rule_temp['hook_id'] === 'user_comment' ) 	{

					// If user is not logged in creates a user class to store email and name
					if ( !is_user_logged_in() ) {

						$user_info = new WPSM_Visitor($commentdata['comment_author_email'], $commentdata['comment_author']);

					} else {

							// if the user us logged in, get details
							$user_info=wp_get_current_user();

						}

					$this->wpsm_call_action($wpsm_rule_temp['service_provider'],$wpsm_rule_temp['action_id'], $user_info, $wpsm_rule_temp['list_id']);

				}
			}
	}

} // CLASS

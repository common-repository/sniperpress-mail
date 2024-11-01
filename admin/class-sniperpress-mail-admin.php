<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://sniperpress.com
 * @since      1.0.0
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/admin
 * @author     SniperPress <sniperpressmail@sniperpress.com>
 */
class sniperpress_mail_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sniperpress-mail-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sniperpress-mail-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-footer', plugin_dir_url( __FILE__ ) . 'js/sniperpress-mail-admin-footer.js', array( 'jquery' ), $this->version, true );

	}

	public function wpsm_add_admin_menu(  ) {

			add_menu_page( 'SniperPress Mail WPP', 'SniperPress Mail', 'manage_options', 'wpsm-admin', array( $this, 'wpsm_options_page' ), 'dashicons-email' );
			add_submenu_page( 'wpsm-admin', 'Options','Options', 'manage_options', 'wpsm-admin', array( $this,'wpsm_options_page') );
			add_submenu_page( 'wpsm-admin', 'Rules', 'Rules', 'manage_options','wpsm_admin_rules', array( $this,'wpsm_rules_section_callback'));

	}

	public function wpsm_settings_init(  ) {

		register_setting( 'WPSM_Services', 'wpsm_settings' ); // Email Services
		add_settings_section('wpsm_WPSM_Services_section',__( 'Email Services Options', 'wordpress' ),array( $this,'wpsm_settings_section_callback'),	'WPSM_Services');

		add_settings_field('getresponse',__( 'GetResponse API Key', 'wordpress' ),array( $this,'getresponse_render'),'WPSM_Services','wpsm_WPSM_Services_section');
		add_settings_field('mailchimp',__( 'MailChimp API Key', 'wordpress' ),array( $this,'mailchimp_render'),'WPSM_Services','wpsm_WPSM_Services_section');

	}


	public function wpsm_options_page(  ) {

			include( plugin_dir_path( __FILE__ ) . 'partials/sniperpress-mail-admin-display.php' );

	}


	public function getresponse_render(  ) {

		$options = get_option( 'wpsm_settings' );

	  echo "<input type='text' name='wpsm_settings[getresponse]' value='";
		echo $options['getresponse'];
		echo "'>";

	}

	public function mailchimp_render(  ) {

		$options = get_option( 'wpsm_settings' );

		echo "<input type='text' name='wpsm_settings[mailchimp]' value='";
		echo $options['mailchimp'];
		echo "'>";

	}

	public function wpsm_settings_section_callback(  ) {

	echo __( 'Please configure your Email Services.', 'wordpress' );

	// TESTES
	//	include( plugin_dir_path( __FILE__ ) . 'testes/mailchimp.php' );

	}

	public function wpsm_rules_section_callback(  ) {
	/**
	 * Builds active rules table, to delete and builds the form to add new ruels
	 */

	// Calls for the global variables
	wpsm_global_vars();

	// get current rules from database
	$wpsm_rules = get_option('wpsm_rules');

	// If the Add new Rule form was submited, adds new rule to rules
	if(isset($_POST['add_rule_submit'])) {

		// Check if all options are set
		if (!isset($_POST['add_rules_hook']) || !isset($_POST['add_rules_service']) || !isset($_POST['add_rules_action']) || !isset($_POST['add_rules_list'])) {
				echo $_POST['add_rule_submit'].'<br />';
				echo "<div class='alert'>There was an error submiting a new rule, please try again.</div>";
				return;
		}
		else {
				// Add new rule to wpsm_rules
				$wpsm_rule=array(
						'service_provider'=>$_POST['add_rules_service'],
						'hook_id'=>$_POST['add_rules_hook'],
						'action_id'=>$_POST['add_rules_action'],
						'list_id'=>$_POST['add_rules_list'],
						'list_name'=>$_POST['add_rules_list_name']
					);

					// add new rule to rules array
					$wpsm_rules[]=$wpsm_rule;

					//update database
					update_option('wpsm_rules',$wpsm_rules);

		}

	}

		// If the users deleted a rule, finds the rule and updates options
	if (isset($_POST['rules'])) {

			$wpsm_count=0;
			$wpsm_new_rules=array();
			foreach ($wpsm_rules as $wpsm_rule) {

				//Create a new array without the deleted array
				if ($wpsm_count!=$_POST['rules']){
						$wpsm_new_rules[]=$wpsm_rule;
				}

			$wpsm_count++;
			}

	  	// reset the original array without the deleted element
			$wpsm_rules=$wpsm_new_rules;
			update_option('wpsm_rules',$wpsm_rules); //update database

	}

	// Builds the variables to create the Active Rules table
	if (!empty($wpsm_rules)) {

		foreach ($wpsm_rules as $wpsm_rule) {

			$wpsm_screen_service=$wpsm_rule['service_provider'];

			// Find Pretty Names of Service REF
			foreach ($GLOBALS['wpsm_services_ref'] as $wpsm_service) {

				//Finds the service provider on REF array (ex: getresponse)
				if ($wpsm_service['service_provider']==$wpsm_screen_service){

						// Finds the Action Pretty Name inside the REF
						foreach ($wpsm_service['actions'] as $wpsm_action_temp) {

							if ($wpsm_action_temp['action_id']==$wpsm_rule['action_id']){

									$wpsm_screen_action=$wpsm_action_temp['action_name'];

							}
						}
				}
			}

			// Find other values
			$wpsm_screen_hook = array_search($wpsm_rule['hook_id'], array_column($GLOBALS['wpsm_hooks_ref'], 'hook_id', 'hook_name')); // hook pretty name
			$wpsm_screen_list = $wpsm_rule['list_name']; // list

			// Builds temp array to build screen table
			$wpsm_screen_row=array(
				'rule_hook'=>$wpsm_screen_hook,
				'rule_service'=>$wpsm_screen_service,
				'rule_action'=>$wpsm_screen_action,
				'rule_list'=>$wpsm_screen_list
			);

			$wpsm_screen_table[]=$wpsm_screen_row;
			}
	}

	   // Creates the rules screen
		include( plugin_dir_path( __FILE__ ) . 'partials/sniperpress-mail-admin-rules.php' );

	}

	public function wpsm_get_rules_callback() {
	/**
	 * 	AJAX
	 *	Builds the HTML to dropbox with EMAIL SERVICE ACTIONS and EMAIL SERVICE LISTS
	 *  Returns an Array with the values for both options dropboxes
	 */

	if(isset($_POST['selected_service'])) {

		$wpms_selected_service=$_POST['selected_service'];
		$response_actions='';
		$response_lists='';

		wpsm_global_vars();

		foreach ($GLOBALS['wpsm_services_ref'] as $wpsm_service_temp)	{

		 	// builds options with available ACTIONS from the seleted EMAIL SERVICE
			if ($wpsm_service_temp['service_provider']==$wpms_selected_service) {

				 foreach ($wpsm_service_temp['actions'] as $wpsm_service_actions)	$response_actions.="<option value='".$wpsm_service_actions['action_id']."'>".$wpsm_service_actions['action_name']."</option>";

			}

		}

		//  Get settings options from DB
		$options = get_option( 'wpsm_settings' );

		if ($wpms_selected_service=='getresponse'){

			// builds options with available LISTS from the seleted EMAIL SERVICE
			$args = array(
				 'headers' => array( 'X-Auth-Token' => 'api-key '.$options['getresponse'] )
			);

			$response = wp_remote_get( 'https://api.getresponse.com/v3/campaigns', $args);
			if( is_array($response) ) {
				$header = $response['headers']; // array of http header lines
				$body = $response['body']; // use the content
				$campaigns=json_decode($body);

				// Builds default option "Please Select"
				$response_lists='<option disabled selected value> -- Please Select -- </option>';
				foreach ($campaigns as $campaign) {

					$response_lists.="<option value='".$campaign->campaignId."'>".$campaign->name."</option>";

				}
			}

		} //if ($wpms_selected_service=='getresponse')

		if ($wpms_selected_service=='mailchimp'){

		// builds options with available LISTS from the seleted EMAIL SERVICE
			$args = array(
				'headers' => array( 'Authorization' => 'apikey '.$options['mailchimp'] )
			);

			$response = wp_remote_get( 'https://us2.api.mailchimp.com/3.0/lists', $args);

			if( is_array($response) ) {
				$header = $response['headers']; // array of http header lines
				$body = $response['body']; // use the content
				$campaigns=json_decode($body);

			 	// Builds default option 'Please Select'
				$response_lists='<option disabled selected value> -- Please Select -- </option>';
				foreach ($campaigns->lists as $campaign) {

					$response_lists.="<option value='".$campaign->id."'>".$campaign->name."</option>";

				}
			}

		}

	}

	$response=array('actions'=>$response_actions, 'lists'=>$response_lists);
	header('Content-Type: application/json');
	echo json_encode($response);

	// this is required to terminate immediately and return a proper response
	wp_die();

	} // function wpsm_get_rules_callback

} //CLASS

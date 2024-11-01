<?php
class WPSM_Visitor {
/**
 *    Class to create a temporary user object to be handled by the email services classes
 *    Used when there are actions from logged out users
 *  (example: a comment from a visitor not registered)
**/

	public $user_email;
	public $user_login;

	public function __construct($user_email, $user_login) {
  	$this->user_email = $user_email;
		$this->user_login = $user_login;
  }

}


/*
 * CUSTOM GLOBAL VARIABLES
 */

function wpsm_global_vars() {

	global $wpsm_services_ref;
	global $wpsm_hooks_ref;

	//Configured Email Services
	$wpsm_services_ref=array(
	   array('service_provider'=>'getresponse', 'name'=>'GetResponse', 'actions' => array(
	       array('action_id'=> 'add_to_list', 'action_name'=>'Add To List', 'action_callback'=>'getresponse_add_to_list'),
	       array('action_id'=> 'remove_from_list', 'action_name'=>'Remove From List', 'action_callback'=>'getresponse_remove_from_list')),
	     ),
	   array('service_provider'=>'mailchimp', 'name'=>'MailChimp', 'actions' => array(
	       array('action_id'=> 'add_to_list', 'action_name'=>'Add To List', 'action_callback'=>'mailchimp_add_to_list'),
	       array('action_id'=> 'remove_from_list', 'action_name'=>'Remove From List', 'action_callback'=>'mailchimp_remove_from_list')),
	       )
	);

	//List of hooks and actions
	 $wpsm_hooks_ref=array(
	 array('hook_id'=>'user_register', 'hook_name'=>'User Register'),
	 array('hook_id'=>'user_comment', 'hook_name'=>'User Comment'),
	);

}

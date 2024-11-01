<?php

class sniperpress_mail_GetResponse extends sniperpress_mail_Email_Services
{

	private $options;
	private $api_key;
	private $headers;


		function __construct() {
	       $this->options = get_option( 'wpsm_settings' );
				 $this->api_key=$this->options['getresponse'];
				 $this->headers=array( 'X-Auth-Token' => 'api-key '.$this->api_key );
	   }

		public function add_to_list($user_info,$list_id){
			/*
				ADDS user to GetResponse List

				@user_info: new registered user in_admin_footer
				@list_id: list ID
			*/

			$args = array(
				'headers' => $this->headers,
				'body' => array('name' => $user_info->user_login,
									'email' => $user_info->user_email,
									'dayOfCycle' => '0',
									'campaign' => array('campaignId' => $list_id))
			);

				// Add email to list
				$response=wp_remote_post( 'https://api.getresponse.com/v3/contacts', $args);

				// If is an error
				if ( is_wp_error( $response ) ) {
						$error_message = $response->get_error_message();
						error_log('WPSM ERROR getresponse_add_to_list:'.$error_message,0);
				}

		}

		private function get_contact_id($user_info,$list_id){
				/* Finds the contactID on a single GetResponse list
				  Returns false if no contact found
				*/

			$args = array(
				'headers' => $this->headers
			);

				// Finds the contact ID
				$response=wp_remote_get( 'https://api.getresponse.com/v3/contacts?query[campaignId]='.$list_id.'&query[email]='.$user_info->user_email, $args);


			//Transform into Array
			 $api_response = json_decode( wp_remote_retrieve_body( $response ), true );;

			 // If didn't find the contact in the list, returns false
			 if (count($api_response)>0) {
			 			return $api_response[0]['contactId'];
			 } else {
				  	return false;
			 }

		}

		public function remove_from_list($user_info,$list_id){
			/*
				REMOVES user from GetResponse List

				@user_info: new registered user in_admin_footer
				@list_id: list ID
			*/

//			$list_id='nQSnN';
//			$user_id=20;
//			$user_info=get_userdata($user_id);	// get new user data

			// If the contact is in the list , deletes it
			if ($contact_id=$this->get_contact_id($user_info,$list_id)){

					$args = array(
						'headers' => $this->headers,
						'method' => 'DELETE'
					);

					// Finds the contact ID
					$response=wp_remote_request( 'https://api.getresponse.com/v3/contacts/'.$contact_id, $args);

					// If is an error
					if ( is_wp_error( $response ) ) {
							$error_message = $response->get_error_message();
							error_log('WPSM ERROR remove_from_list:'.$error_message,0);
					}


			}

		} // remove_from_list

} //Class

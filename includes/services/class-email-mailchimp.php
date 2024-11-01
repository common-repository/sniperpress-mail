<?php

class sniperpress_mail_MailChimp extends sniperpress_mail_Email_Services {

	private $options;
	private $api_key;
	private $headers;
	private $api_url;

		function __construct() {

	       $this->options = get_option( 'wpsm_settings' );
				 $this->api_key=$this->options['mailchimp'];

				 list(, $data_center) = explode('-', $this->api_key);

   		   $this->api_url  = str_replace('<dc>', $data_center, 'https://<dc>.api.mailchimp.com/3.0/');

				 $this->headers=array( 'Authorization' => 'apikey '.$this->api_key );


	   }

		public function add_to_list($user_info,$list_id){
			/*
				ADDS user to MailChimp List

				@user_info: new registered user
				@list_id: list ID

			*/
			$data=array('email_address' => $user_info->user_email,
								'status' => 'subscribed',
								'ip_signup' => $_SERVER['REMOTE_ADDR'],
								'timestamp_signup' => $_SERVER['REQUEST_TIME']
							);

  		$body = json_encode($data);

			$args = array(
				'headers' => $this->headers,
				'body' => $body
			);

				// Add email to list
				$response=wp_remote_post( $this->api_url.'lists/'.$list_id.'/members', $args);

				// If is an error
				if ( is_wp_error( $response ) ) {
						$error_message = $response->get_error_message();
						error_log('WPSM ERROR mailchimp_add_to_list:'.$error_message,0);
				}

		}

		public function remove_from_list($user_info,$list_id){
			/*
				REMOVES user from MailChimp List

				@user_info: user id
				@list_id: list ID
			*/

			// builds the hash of the lowercase email address
			$lower_email = md5(strtolower($user_info->user_email));

			$args = array(
				'headers' => $this->headers,
				'method' => 'DELETE'
			);

  		$response=wp_remote_request( $this->api_url.'lists/'.$list_id.'/members/'.$lower_email, $args);

			// If is an error
			if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					error_log('WPSM ERROR remove_from_list:'.$error_message,0);
			}

		} // remove_from_list

} //Class

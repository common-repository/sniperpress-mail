<?php

$test_email='freelancers.pa@gmail.com';
$list_id='b057ae7e47';
$test_api='faa25c797fba4cc24a49f74ea4372a56-us2';

echo '<hr>';
echo '<h2>TEST ZONE</h2>';


// ADD USER TO LIST

/*
echo $test_api.'<br />';
echo $test_email.'<br />';
echo $list_id.'<br />';


$data = array(
	'email_address' => $test_email,
	'status' => 'subscribed',
	'ip_signup' => $_SERVER['REMOTE_ADDR'],
	'timestamp_signup' => $_SERVER['REQUEST_TIME']
);

$body = json_encode($data);

echo $body;

// ADD USER TO LIST
$args = array(
		'headers' => array(
			"Authorization" => "apikey ".$test_api
		),
  	'body' => $body
);

  // Add email to list
  $response=wp_remote_post( 'https://us2.api.mailchimp.com/3.0/lists/'.$list_id.'/members', $args);

print_r($response);

  // If is an error
  if ( is_wp_error( $response ) ) {
		echo 'erro:'. $response->get_error_message();
  }
*/
// ADD USER TO LIST - END


/*
//LIST CAMPAIGNS
	$args = array(
		'headers' => array( "Authorization" => "apikey ".$test_api."" )
	);

	$response = wp_remote_get( 'https://us2.api.mailchimp.com/3.0/lists', $args);

	if( is_array($response) ) {
				$header = $response['headers']; // array of http header lines
				$body = $response['body']; // use the content
				$campaigns=json_decode($body);

				// Builds default option "Please Select"
				//$response_lists="<option disabled selected value> -- Please Select -- </option>";
				foreach ($campaigns->lists as $campaign) {

					echo '<br />AAA<br />';
					echo($campaign->name);
										echo '<hr>';
					echo($campaign->id);
					echo '<hr>';


				}
		}

//LIST CAMPAIGNS - END
*/

echo '<hr>';

?>

<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://sniperpress.com
 * @since      1.0.0
 *
 * @package    sniperpress_mail
 * @subpackage sniperpress_mail/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form action='options.php' method='post'>

  <!-- Add the icon to the page -->

  <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
  <?php settings_errors(); ?>

  <?php

      echo '<h1>SniperPress Mail Options</h1>';
      echo '<hr>';

    settings_fields( 'WPSM_Services' );
    do_settings_sections( 'WPSM_Services' );

    submit_button();

  ?>

</form>

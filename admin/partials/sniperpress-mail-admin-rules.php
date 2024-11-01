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

<h1>SniperPress Mail Rules</h1>
<hr>
<h2>Active Rules</h2>

<?php

// If no rules defined yet, warning

if (empty($wpsm_rules)){

	echo 'No rules created yet, please add some below.';

} else {

		echo __( 'These are the current active rules. To remove, select and click the "Remove Rule" button:<br />', 'wordpress' );

 ?>

<!-- Builds Form for adding new rules-->
<!-- Create Radio Buttons-->
<form id='formRules' method='post' action=''>

<table border='1px solid black;'>
  <tr>
    <th>SELECT</th>
    <th>WORDPRESS HOOK</th>
    <th>EMAIL SERVICE</th>
    <th>EMAIL ACTION</th>
    <th>LIST NAME</th>

  </tr>
    <?php
        $wpsm_array_position=0;
        foreach ($wpsm_screen_table as $wpsm_screen_row) {
      ?>
  <tr>

        <td align='center'><input type='radio' id='rule_id' name='rules' value='<?php echo($wpsm_array_position); ?>'</td>
        <td><?php echo ($wpsm_screen_row['rule_hook']); ?></td>
        <td><?php echo ($wpsm_screen_row['rule_service']); ?></td>
        <td><?php echo ($wpsm_screen_row['rule_action']); ?></td>
        <td><?php echo ($wpsm_screen_row['rule_list']); ?></td>

  </tr>

    <?php
    $wpsm_array_position++;
    } ?>

</table>

<input type='submit' value='Remove Rule' >

</form>

<?php } //if (empty($wpsm_rules)){
  ?>

<hr>
<h2>Add New Rules</h2>

<form id='formRules' onsubmit='return isValidForm()' method='post' action=''>

	<div id='wpsm_alert_div' ></div>

			1. Select Hook:
		<select name='add_rules_hook' id='add_rules_hook' onChange='formRulesChanged("add_rules_hook")'>
			<option disabled selected value > -- Please Select -- </option>
			<?php	foreach ($GLOBALS['wpsm_hooks_ref'] as $wpsm_hook)	echo "<option  value='".$wpsm_hook['hook_id']."'>".$wpsm_hook['hook_name']."</option>";	?>
		</select>
		<br />
		2. Select Email Service:
	<select name='add_rules_service' id='add_rules_service' disabled onChange='fetch_rules_actions(this.options[this.selectedIndex].text)'>
		<option disabled selected value> -- Please Select -- </option>
			<?php

			$wpsm_services = get_option( 'wpsm_settings' );
			while ($wpsm_service = current($wpsm_services)) {
						// Only returns configured EMAIL SERVICES

									if ($wpsm_service!=''){
										echo "<option value='".key($wpsm_services)."'>".key($wpsm_services)."</option>";
									}

 			next($wpsm_services);


						}?>
	</select>
		<br />
		3. Select Email Action:
	<select name='add_rules_action' id='add_rules_action' disabled onChange='formRulesChanged("")'>
			<option disabled selected value> -- Please Select -- </option>
	</select>
	<br />
	4. Select Email List:
<select name='add_rules_list' id='add_rules_list' disabled onChange="formRulesChanged('add_rules_list')">
		<option disabled selected value> -- Please Select -- </option>
</select>
<input type='hidden' name='add_rules_list_name' id='add_rules_list_name'>
<br />
<input type='submit' value='Add Rule' name='add_rule_submit' id='add_rule_submit' disabled>

</form>

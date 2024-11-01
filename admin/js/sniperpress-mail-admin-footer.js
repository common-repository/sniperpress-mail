function formRulesChanged(selectElement) {
// Enables select options boxes

	if (selectElement=='add_rules_hook') jQuery('#add_rules_service').prop('disabled',false);

	// Hides the list name on the hidden add_list_name field
	if (selectElement=='add_rules_list') {

				jQuery('#add_rule_submit').prop('disabled',false);
				jQuery('#add_rules_list_name').val(jQuery('#add_rules_list option:selected').text());

	}
}

function fetch_rules_actions(EmailService) {

	jQuery('#add_rules_action').prop('disabled',true);
	jQuery('#add_rules_list').prop('disabled',true);

	var data = {
		'action': 'wpms_rules',
		dataType: 'JSON',
		'selected_service': EmailService
	}

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {

			jQuery('#add_rules_action').html(response.actions);
			jQuery('#add_rules_list').html(response.lists);
			jQuery('#add_rules_action').prop('disabled',false);
			jQuery('#add_rules_list').prop('disabled',false);

	});

};

function isValidForm() {

	// Form validation before calling action
	var form_ok = true;
	var form_msg='';

	// Make sure all form fields have values
	if (document.getElementsByName('add_rules_list').item(0).value.length == 0){
		form_msg='Please select an Email List';
		form_ok=false;
	}

	if (document.getElementsByName('add_rules_action').item(0).value.length == 0){
		form_msg='Please select an Email Action';
		form_ok=false;
	}

	if (document.getElementsByName('add_rules_service').item(0).value.length == 0){
		form_msg='Please select an Email Service';
		form_ok=false;
	}

	if (document.getElementsByName('add_rules_hook').item(0).value.length == 0){
		form_msg='Please select a Hook';
		form_ok=false;
	}


	if (!form_ok) {

		// Error box
		var el = document.getElementById('wpsm_alert_div');
	   if(el) {
	     el.className += el.className ? ' alert' : 'alert';
	   }

		el.innerHTML=form_msg;
	}

	return form_ok;

}

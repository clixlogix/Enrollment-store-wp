<?php
/**
 * InsuranceAncora Framework: messages subsystem
 *
 * @package	insurance_ancora
 * @since	insurance_ancora 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('insurance_ancora_messages_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_messages_theme_setup' );
	function insurance_ancora_messages_theme_setup() {
		// Core messages strings
		add_filter('insurance_ancora_filter_localize_script', 'insurance_ancora_messages_localize_script');
        add_filter('insurance_ancora_action_add_scripts_inline', 'insurance_ancora_messages_localize_script');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_get_error_msg')) {
	function insurance_ancora_get_error_msg() {
		return insurance_ancora_storage_get('error_msg');
	}
}

if (!function_exists('insurance_ancora_set_error_msg')) {
	function insurance_ancora_set_error_msg($msg) {
		$msg2 = insurance_ancora_get_error_msg();
		insurance_ancora_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('insurance_ancora_get_success_msg')) {
	function insurance_ancora_get_success_msg() {
		return insurance_ancora_storage_get('success_msg');
	}
}

if (!function_exists('insurance_ancora_set_success_msg')) {
	function insurance_ancora_set_success_msg($msg) {
		$msg2 = insurance_ancora_get_success_msg();
		insurance_ancora_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('insurance_ancora_get_notice_msg')) {
	function insurance_ancora_get_notice_msg() {
		return insurance_ancora_storage_get('notice_msg');
	}
}

if (!function_exists('insurance_ancora_set_notice_msg')) {
	function insurance_ancora_set_notice_msg($msg) {
		$msg2 = insurance_ancora_get_notice_msg();
		insurance_ancora_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('insurance_ancora_set_system_message')) {
	function insurance_ancora_set_system_message($msg, $status='info', $hdr='') {
		update_option(insurance_ancora_storage_get('options_prefix') . '_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('insurance_ancora_get_system_message')) {
	function insurance_ancora_get_system_message($del=false) {
		$msg = get_option(insurance_ancora_storage_get('options_prefix') . '_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			insurance_ancora_del_system_message();
		return $msg;
	}
}

if (!function_exists('insurance_ancora_del_system_message')) {
	function insurance_ancora_del_system_message() {
		delete_option(insurance_ancora_storage_get('options_prefix') . '_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('insurance_ancora_messages_localize_script')) {
	function insurance_ancora_messages_localize_script($vars) {
		$vars['strings'] = array(
			'ajax_error'		=> esc_html__('Invalid server answer', 'insurance-ancora'),
			'bookmark_add'		=> esc_html__('Add the bookmark', 'insurance-ancora'),
            'bookmark_added'	=> esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'insurance-ancora'),
            'bookmark_del'		=> esc_html__('Delete this bookmark', 'insurance-ancora'),
            'bookmark_title'	=> esc_html__('Enter bookmark title', 'insurance-ancora'),
            'bookmark_exists'	=> esc_html__('Current page already exists in the bookmarks list', 'insurance-ancora'),
			'search_error'		=> esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'insurance-ancora'),
			'email_confirm'		=> esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'insurance-ancora'),
			'reviews_vote'		=> esc_html__('Thanks for your vote! New average rating is:', 'insurance-ancora'),
			'reviews_error'		=> esc_html__('Error saving your vote! Please, try again later.', 'insurance-ancora'),
			'error_like'		=> esc_html__('Error saving your like! Please, try again later.', 'insurance-ancora'),
			'error_global'		=> esc_html__('Global error text', 'insurance-ancora'),
			'name_empty'		=> esc_html__('The name can\'t be empty', 'insurance-ancora'),
			'name_long'			=> esc_html__('Too long name', 'insurance-ancora'),
			'email_empty'		=> esc_html__('Too short (or empty) email address', 'insurance-ancora'),
			'email_long'		=> esc_html__('Too long email address', 'insurance-ancora'),
			'email_not_valid'	=> esc_html__('Invalid email address', 'insurance-ancora'),
			'subject_empty'		=> esc_html__('The subject can\'t be empty', 'insurance-ancora'),
			'subject_long'		=> esc_html__('Too long subject', 'insurance-ancora'),
			'text_empty'		=> esc_html__('The message text can\'t be empty', 'insurance-ancora'),
			'text_long'			=> esc_html__('Too long message text', 'insurance-ancora'),
			'send_complete'		=> esc_html__("Send message complete!", 'insurance-ancora'),
			'send_error'		=> esc_html__('Transmit failed!', 'insurance-ancora'),
			'not_agree'			=> esc_html__('Please, check \'I agree with Terms and Conditions\'', 'insurance-ancora'),
			'login_empty'		=> esc_html__('The Login field can\'t be empty', 'insurance-ancora'),
			'login_long'		=> esc_html__('Too long login field', 'insurance-ancora'),
			'login_success'		=> esc_html__('Login success! The page will be reloaded in 3 sec.', 'insurance-ancora'),
			'login_failed'		=> esc_html__('Login failed!', 'insurance-ancora'),
			'password_empty'	=> esc_html__('The password can\'t be empty and shorter then 4 characters', 'insurance-ancora'),
			'password_long'		=> esc_html__('Too long password', 'insurance-ancora'),
			'password_not_equal'	=> esc_html__('The passwords in both fields are not equal', 'insurance-ancora'),
			'registration_success'	=> esc_html__('Registration success! Please log in!', 'insurance-ancora'),
			'registration_failed'	=> esc_html__('Registration failed!', 'insurance-ancora'),
			'geocode_error'			=> esc_html__('Geocode was not successful for the following reason:', 'insurance-ancora'),
			'googlemap_not_avail'	=> esc_html__('Google map API not available!', 'insurance-ancora'),
			'editor_save_success'	=> esc_html__("Post content saved!", 'insurance-ancora'),
			'editor_save_error'		=> esc_html__("Error saving post data!", 'insurance-ancora'),
			'editor_delete_post'	=> esc_html__("You really want to delete the current post?", 'insurance-ancora'),
			'editor_delete_post_header'	=> esc_html__("Delete post", 'insurance-ancora'),
			'editor_delete_success'	=> esc_html__("Post deleted!", 'insurance-ancora'),
			'editor_delete_error'	=> esc_html__("Error deleting post!", 'insurance-ancora'),
			'editor_caption_cancel'	=> esc_html__('Cancel', 'insurance-ancora'),
			'editor_caption_close'	=> esc_html__('Close', 'insurance-ancora')
			);
		return $vars;
	}
}
?>
<?php
/**
 * Send email to subscribers from selected group
 */
 
// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('insurance_ancora_emailer_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_emailer_theme_setup' );
	function insurance_ancora_emailer_theme_setup() {
		// AJAX: Save e-mail in subscribe list
		add_action('wp_ajax_emailer_submit',				'insurance_ancora_callback_emailer_submit');
		add_action('wp_ajax_nopriv_emailer_submit',			'insurance_ancora_callback_emailer_submit');
		// AJAX: Confirm e-mail in subscribe list
		add_action('wp_ajax_emailer_confirm',				'insurance_ancora_callback_emailer_confirm');
		add_action('wp_ajax_nopriv_emailer_confirm',		'insurance_ancora_callback_emailer_confirm');
		// AJAX: Get subscribers list if group changed
		add_action('wp_ajax_emailer_group_getlist',			'insurance_ancora_callback_emailer_group_getlist');
		add_action('wp_ajax_nopriv_emailer_group_getlist',	'insurance_ancora_callback_emailer_group_getlist');
	}
}

if (!function_exists('insurance_ancora_emailer_theme_setup2')) {
	add_action( 'insurance_ancora_action_after_init_theme', 'insurance_ancora_emailer_theme_setup2' );		// Fire this action after load theme options
	function insurance_ancora_emailer_theme_setup2() {
		if (is_admin() && current_user_can('manage_options') && insurance_ancora_get_theme_option('admin_emailer')=='yes') {
			new insurance_ancora_emailer();
		}
	}
}


class insurance_ancora_emailer {

	var $subscribers  = array();
	var $error    = '';
	var $success  = '';
	var $max_recipients_in_one_letter = 50;

	//-----------------------------------------------------------------------------------
	// Constuctor
	//-----------------------------------------------------------------------------------
	function __construct() {
		// Setup actions handlers
		add_action('admin_menu', array($this, 'admin_menu_item'));
		add_action("admin_enqueue_scripts", array($this, 'load_scripts'));

		// Init properties
		$this->subscribers = insurance_ancora_emailer_group_getlist();
	}

	//-----------------------------------------------------------------------------------
	// Admin Interface
	//-----------------------------------------------------------------------------------
	function admin_menu_item() {
		if ( current_user_can( 'manage_options' ) ) {
			// 'theme' - add in the 'Appearance'
			// 'management' - add in the 'Tools'
			insurance_ancora_admin_add_menu_item('theme', array(
				'page_title' => esc_html__('Emailer', 'trx_utils'),
				'menu_title' => esc_html__('Emailer', 'trx_utils'),
				'capability' => 'manage_options',
				'menu_slug'  => 'trx_emailer',
				'callback'   => array($this, 'build_page'),
				'icon'		 => ''
				)
			);
		}
	}


	//-----------------------------------------------------------------------------------
	// Load required styles and scripts
	//-----------------------------------------------------------------------------------
	function load_scripts() {
		if (isset($_REQUEST['page']) && $_REQUEST['page']=='trx_emailer') {
			wp_enqueue_style('trx-emailer-style', trx_utils_get_file_url('tools/emailer/emailer.css'), array(), null);
			wp_deregister_style('jquery_ui');
			wp_deregister_style('date-picker-css');

			wp_enqueue_script('jquery-ui-core', false, array('jquery'), null, true);
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
			wp_enqueue_script('trx-emailer-script', trx_utils_get_file_url('tools/emailer/emailer.js'), array('jquery'), null, true);

			wp_localize_script( 'trx-emailer-script', 'INSURANCE_ANCORA_EMAILER', array(
				'ajax_nonce' => wp_create_nonce(admin_url('admin-ajax.php')),
                'ajax_url'   => esc_url(admin_url('admin-ajax.php')),
                'ajax_error' => esc_html__('Invalid server answer!', 'trx_utils')
			) );
		}
	}
	
	
	//-----------------------------------------------------------------------------------
	// Build the Main Page
	//-----------------------------------------------------------------------------------
	function build_page() {
		
		$mail = insurance_ancora_get_theme_option('mail_function');

		$subject = $message = $attach = $group = $sender_name = $sender_email = '';
		$subscribers_update = $subscribers_delete = $subscribers_clear = false;
		$subscribers = array();
		
		if ( isset($_POST['emailer_subject']) ) {
			do {
				// Check nonce
				if ( !wp_verify_nonce( insurance_ancora_get_value_gp('nonce'), admin_url('admin-ajax.php') ) ) {
					$this->error = esc_html__('Incorrect WP-nonce data! Operation canceled!', 'trx_utils');
					break;
				}
				// Get post data
				$subject = insurance_ancora_get_value_gp('emailer_subject');
				if (empty($subject)) {
					$this->error = esc_html__('Subject can not be empty! Operation canceled!', 'trx_utils');
					break;
				}
				$message = insurance_ancora_get_value_gp('emailer_message');
				if (empty($message)) {
					$this->error = esc_html__('Message can not be empty! Operation canceled!', 'trx_utils');
					break;
				}
				$attach  = isset($_FILES['emailer_attachment']['tmp_name']) && file_exists($_FILES['emailer_attachment']['tmp_name']) ? $_FILES['emailer_attachment']['tmp_name'] : '';
				$group   = insurance_ancora_get_value_gp('emailer_group');
				$subscribers = insurance_ancora_get_value_gp('emailer_subscribers');
				if (!empty($subscribers))
					$subscribers = explode("\n", str_replace(array(';', ','), array("\n", "\n"), $subscribers));
				else
					$subscribers = array();
				if (count($subscribers)==0) {
					$this->error = esc_html__('Subscribers lists are empty! Operation canceled!', 'trx_utils');
					break;
				}
				$sender_name = insurance_ancora_get_value_gp('emailer_sender_name', get_bloginfo('name'));
				$sender_email = insurance_ancora_get_value_gp('emailer_sender_email');
				if (empty($sender_email)) $sender_email = insurance_ancora_get_theme_option('contact_email');
				if (empty($sender_email)) $sender_email = get_bloginfo('admin_email');
				if (empty($sender_email)) {
					$this->error = esc_html__('Sender email is empty! Operation canceled!', 'trx_utils');
					break;
				}
				$headers = 'From: ' . strip_tags($sender_name) . ' <' . trim($sender_email) . '>' . "\r\n"
							. 'Content-Type: text/html; charset=UTF-8' . "\r\n";

				$subscribers_update = isset($_POST['emailer_subscribers_update']);
				$subscribers_delete = isset($_POST['emailer_subscribers_delete']);
				$subscribers_clear  = isset($_POST['emailer_subscribers_clear']);

				// Send email
				$new_list = array();
				$list = array();
				$cnt = 0;
				if (is_array($subscribers) && count($subscribers) > 0) {
					foreach ($subscribers as $email) {
						$email = trim(chop($email));
						if (empty($email)) continue;
						if (!preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) continue;
						$list[] = $email;
						$cnt++;
						if ($cnt >= $this->max_recipients_in_one_letter) {
							$rez = $mail == 'mail' 
								? @mail( join(',', $list), $subject, $message, $headers)
								: @wp_mail( $list, $subject, $message, $headers, $attach );
							if (!$rez) {
								$err_msg = esc_html__('Error occured when send message!', 'trx_utils');
								$cnt = 0;
								break;
							}
							if ($subscribers_update && $group!='none') $new_list = array_merge($new_list, $list);
							$list = array();
							$cnt = 0;
						}
					}
				}
				$add_msg = $err_msg = '';
				if ($cnt > 0) {
					$rez = $mail == 'mail' 
						? @mail( join(',', $list), $subject, $message, $headers)
						: @wp_mail( $list, $subject, $message, $headers, $attach );
					if (!$rez)
						$err_msg = esc_html__('Error occured when send message!', 'trx_utils');
					if ($subscribers_update && $group!='none') $new_list = array_merge($new_list, $list);
					$list = array();
					$cnt = 0;
				}
				if ($subscribers_update && $group!='none') {
					$rez = array();
					if (is_array($this->subscribers[$group]) && count($this->subscribers[$group]) > 0) {
						foreach ($this->subscribers[$group] as $k=>$v) {
							if (!$subscribers_clear && !empty($v))
								$rez[$k] = $v;
						}
					}
					if (is_array($new_list) && count($new_list) > 0) {
						foreach ($new_list as $v) {
							$rez[$v] = '';
						}
					}
					$this->subscribers[$group] = $rez;
					update_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', $this->subscribers);
					$add_msg .= esc_html__('The subscriber list is updated', 'trx_utils');
				} else if ($subscribers_delete && $group!='none') {
					unset($this->subscribers[$group]);
					update_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', $this->subscribers);
					$add_msg .= esc_html__('The subscriber list is cleared', 'trx_utils');
				}
				if ($err_msg)
					$this->error = $err_msg;
				else
					$this->success = esc_html__('E-Mail was send successfull!', 'trx_utils') . ($add_msg ? ' '.trim($add_msg) : '');
			} while (false);
		}

		?>
		<div class="trx_emailer">
			<h2 class="trx_emailer_title"><?php esc_html_e('Insurance Emailer', 'trx_utils'); ?></h2>
			<div class="trx_emailer_result">
				<?php if (!empty($this->error)) { ?>
				<div class="error">
					<p><?php echo trim($this->error); ?></p>
				</div>
				<?php } ?>
				<?php if (!empty($this->success)) { ?>
				<div class="updated">
					<p><?php echo trim($this->success); ?></p>
				</div>
				<?php } ?>
			</div>
	
			<form id="trx_emailer_form" action="#" method="post" enctype="multipart/form-data">

				<input type="hidden" value="<?php echo esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))); ?>" name="nonce" />

				<div class="trx_emailer_block">
					<fieldset class="trx_emailer_block_inner">
						<legend> <?php esc_html_e('Letter data', 'trx_utils'); ?> </legend>
						<div class="trx_emailer_fields">
							<div class="trx_emailer_field trx_emailer_subject">
								<label for="emailer_subject"><?php esc_html_e('Subject:', 'trx_utils'); ?></label>
								<input type="text" value="<?php echo esc_attr($subject); ?>" name="emailer_subject" id="emailer_subject" />
							</div>
							<?php if ($mail=='wp_mail') { ?>
								<div class="trx_emailer_field trx_emailer_attachment">
									<label for="emailer_attachment"><?php esc_html_e('Attachment:', 'trx_utils'); ?></label>
									<input type="file" name="emailer_attachment" id="emailer_attachment" />
								</div>
							<?php } ?>
							<div class="trx_emailer_field trx_emailer_message">
								<?php
								wp_editor( $message, 'emailer_message', array(
									'wpautop' => false,
									'textarea_rows' => 10
								));
								?>								
							</div>
						</div>
					</fieldset>
				</div>
	
				<div class="trx_emailer_block">
					<fieldset class="trx_emailer_block_inner">
						<legend> <?php esc_html_e('Subscribers', 'trx_utils'); ?> </legend>
						<div class="trx_emailer_fields">
							<div class="trx_emailer_field trx_emailer_group">
								<label for="emailer_group"><?php esc_html_e('Select group:', 'trx_utils'); ?></label>
								<select name="emailer_group" id="emailer_group">
									<option value="none"<?php echo ('none'==$group ? ' selected="selected"' : ''); ?>><?php esc_html_e('- Select group -', 'trx_utils'); ?></option>
									<?php
									if (is_array($this->subscribers) && count($this->subscribers) > 0) {
										foreach ($this->subscribers as $gr=>$list) {
											echo '<option value="'.esc_attr($gr).'"'.($group==$gr ? ' selected="selected"' : '').'>'.insurance_ancora_strtoproper($gr).'</option>';
										}
									}
									?>
								</select>
								<input type="checkbox" name="emailer_subscribers_update" id="emailer_subscribers_update" value="1"<?php echo !empty($subscribers_update) ? ' checked="checked"' : ''; ?> /><label for="emailer_subscribers_update" class="inline" title="<?php esc_attr_e('Update the subscribers list for selected group', 'trx_utils'); ?>"><?php esc_html_e('Update', 'trx_utils'); ?></label>
								<input type="checkbox" name="emailer_subscribers_clear" id="emailer_subscribers_clear" value="1"<?php echo !empty($subscribers_clear) ? ' checked="checked"' : ''; ?> /><label for="emailer_subscribers_clear" class="inline" title="<?php esc_attr_e('Clear this group from not confirmed emails after send', 'trx_utils'); ?>"><?php esc_html_e('Clear', 'trx_utils'); ?></label>
								<input type="checkbox" name="emailer_subscribers_delete" id="emailer_subscribers_delete" value="1"<?php echo !empty($subscribers_delete) ? ' checked="checked"' : ''; ?> /><label for="emailer_subscribers_delete" class="inline" title="<?php esc_attr_e('Delete this group after send', 'trx_utils'); ?>"><?php esc_html_e('Delete', 'trx_utils'); ?></label>
							</div>
							<div class="trx_emailer_field trx_emailer_subscribers2">
								<label for="emailer_subscribers" class="big"><?php esc_html_e('List of recipients:', 'trx_utils'); ?></label>
								<textarea name="emailer_subscribers" id="emailer_subscribers"><?php echo join("\n", $subscribers); ?></textarea>
							</div>
							<div class="trx_emailer_field trx_emailer_sender_name">
								<label for="emailer_sender_name"><?php esc_html_e('Sender name:', 'trx_utils'); ?></label>
								<input type="text" name="emailer_sender_name" id="emailer_sender_name" value="<?php echo esc_attr($sender_name); ?>" /><br />
							</div>
							<div class="trx_emailer_field trx_emailer_sender_email">
								<label for="emailer_sender_email"><?php esc_html_e('Sender email:', 'trx_utils'); ?></label>
								<input type="text" name="emailer_sender_email" id="emailer_sender_email" value="<?php echo esc_attr($sender_email); ?>" />
							</div>
						</div>
					</fieldset>
				</div>
	
				<div class="trx_emailer_buttons">
					<a href="#" id="trx_emailer_send"><?php echo esc_html_e('Send', 'trx_utils'); ?></a>
				</div>
	
			</form>
		</div>
		<?php
	}

}


//==========================================================================================
// Utilities
//==========================================================================================

// Save e-mail in subscribe list
if ( !function_exists( 'insurance_ancora_callback_emailer_submit' ) ) {
	function insurance_ancora_callback_emailer_submit() {

		if ( !wp_verify_nonce( insurance_ancora_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		$response = array('error'=>'');

		$group = $_REQUEST['group'];
		$email = $_REQUEST['email'];

		if (preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) {
			$subscribers = insurance_ancora_emailer_group_getlist($group);
			if (isset($subscribers[$group][$email]))
				$response['error'] = esc_html__('E-mail address already in the subscribers list!', 'trx_utils');
			else {
				$subscribers[$group][$email] = md5(mt_rand());
				update_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', $subscribers);
				$subj = sprintf(esc_html__('Site %s - Subscribe confirmation', 'trx_utils'), get_bloginfo('site_name'));
				$url = admin_url('admin-ajax.php');
				$link = $url . (insurance_ancora_strpos($url, '?')===false ? '?' : '') . 'action=emailer_confirm&nonce='.urlencode($subscribers[$group][$email]).'&email='.urlencode($email).'&group='.urlencode($group);
				$msg = sprintf(__("You or someone else added this e-mail address into our subcribtion list.\nPlease, confirm your wish to receive newsletters from our website by clicking on the link below:\n\n<a href=\"%s\">%s</a>\n\nIf you do not wiish to subscribe to our newsletters, simply ignore this message.", 'trx_utils'), $link, $link);
				$sender_name = get_bloginfo('name');
				$sender_email = insurance_ancora_get_theme_option('contact_email');
				if (empty($sender_email)) $sender_email = get_bloginfo('admin_email');
				$headers = 'From: ' . strip_tags($sender_name).' <' . trim($sender_email) . '>' . "\r\n"
							. 'Content-Type: text/html' . "\r\n";
				$mail = insurance_ancora_get_theme_option('mail_function');
				$rez = $mail == 'mail' 
					? @mail( $email, $subj, nl2br($msg), $headers)
					: @wp_mail( $email, $subj, nl2br($msg), $headers );
				if (!$rez) {
					$response['error'] = esc_html__('Error send message!', 'trx_utils');
				}
			}
		} else
			$response['error'] = esc_html__('E-mail address is not valid!', 'trx_utils');
		echo json_encode($response);
		die();
	}
}

// Confirm e-mail in subscribe list
if ( !function_exists( 'insurance_ancora_callback_emailer_confirm' ) ) {
	function insurance_ancora_callback_emailer_confirm() {
		
		$group = $_REQUEST['group'];
		$email = $_REQUEST['email'];
		$nonce = $_REQUEST['nonce'];
		if (preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) {
			$subscribers = insurance_ancora_emailer_group_getlist($group);
			if (isset($subscribers[$group][$email])) {
				if ($subscribers[$group][$email] == $nonce) {
					$subscribers[$group][$email] = '';
					update_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', $subscribers);
					insurance_ancora_set_system_message(esc_html__('Confirmation complete! E-mail address succefully added in the subscribers list!', 'trx_utils'), 'success');
					//header('Location: '.home_url('/'));
					wp_safe_redirect( home_url('/') );
				} else if ($subscribers[$group][$email] != '') {
					insurance_ancora_set_system_message(esc_html__('Bad confirmation code!', 'trx_utils'), 'error');
					//header('Location: '.home_url('/'));
					wp_safe_redirect( home_url('/') );
				} else {
					insurance_ancora_set_system_message(esc_html__('E-mail address already exists in the subscribers list!', 'trx_utils'), 'error');
					//header('Location: '.home_url('/'));
					wp_safe_redirect( home_url('/') );
				}
			}
		}
		die();
	}
}


// Get subscribers list if group changed
if ( !function_exists( 'insurance_ancora_callback_emailer_group_getlist' ) ) {
	function insurance_ancora_callback_emailer_group_getlist() {
		
		if ( !wp_verify_nonce( insurance_ancora_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
	
		$response = array('error'=>'', 'subscribers' => '');
		
		$group = $_REQUEST['group'];
		$subscribers = insurance_ancora_emailer_group_getlist($group);
		$list = array();
		if (isset($subscribers[$group]) && is_array($subscribers[$group]) && count($subscribers[$group]) > 0) {
			foreach ($subscribers[$group] as $k=>$v) {
				if (empty($v))
					$list[] = $k;
			}
		}
		$response['subscribers'] = join("\n", $list);

		echo json_encode($response);
		die();
	}
}

// Get Subscribers list
if ( !function_exists( 'insurance_ancora_emailer_group_getlist' ) ) {
	function insurance_ancora_emailer_group_getlist($group='') {
		$subscribers = get_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', array());
		if (!is_array($subscribers))
			$subscribers = array();
		if (!empty($group) && (!isset($subscribers[$group]) || !is_array($subscribers[$group])))
			$subscribers[$group] = array();
		if (is_array($subscribers) && count($subscribers) > 0) {
			$need_save = false;
			foreach ($subscribers as $grp=>$list) {
				if (isset($list[0])) {	// Plain array - old format - convert it
					$rez = array();
					foreach ($list as $v) {
						$rez[$v] = '';
					}
					$subscribers[$grp] = $rez;
					$need_save = true;
				}
			}
			if ($need_save)
				update_option(insurance_ancora_storage_get('options_prefix') . '_emailer_subscribers', $subscribers);
		}
		return $subscribers;
	}
}
?>
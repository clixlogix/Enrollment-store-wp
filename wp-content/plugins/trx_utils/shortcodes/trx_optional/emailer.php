<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('insurance_ancora_sc_emailer_theme_setup')) {
	add_action( 'insurance_ancora_action_before_init_theme', 'insurance_ancora_sc_emailer_theme_setup' );
	function insurance_ancora_sc_emailer_theme_setup() {
		add_action('insurance_ancora_action_shortcodes_list', 		'insurance_ancora_sc_emailer_reg_shortcodes');
		if (function_exists('insurance_ancora_exists_visual_composer') && insurance_ancora_exists_visual_composer())
			add_action('insurance_ancora_action_shortcodes_list_vc','insurance_ancora_sc_emailer_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_emailer group=""]

if (!function_exists('insurance_ancora_sc_emailer')) {	
	function insurance_ancora_sc_emailer($atts, $content = null) {
		if (insurance_ancora_in_shortcode_blogger()) return '';
		extract(insurance_ancora_html_decode(shortcode_atts(array(
			// Individual params
			"group" => "",
			"open" => "yes",
			"align" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => "",
			"width" => "",
			"height" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . insurance_ancora_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= insurance_ancora_get_css_dimensions_from_values($width, $height);
		// Load core messages
		insurance_ancora_enqueue_messages();
        $page = get_option('wp_page_for_privacy_policy');
        $privacy = trx_utils_get_privacy_text();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
					. ' class="sc_emailer' . ($align && $align!='none' ? ' align' . esc_attr($align) : '') . (insurance_ancora_param_is_on($open) ? ' sc_emailer_opened' : '') . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
					. ($css ? ' style="'.esc_attr($css).'"' : '') 
					. (!insurance_ancora_param_is_off($animation) ? ' data-animation="'.esc_attr(insurance_ancora_get_animation_classes($animation)).'"' : '')
					. '>'
				. '<form class="sc_emailer_form">'
				. '<input type="text" class="sc_emailer_input" name="email" value="" placeholder="'.esc_attr__('Please, enter you email address.', 'trx_utils').'">'
				. '<a href="#" class="sc_emailer_button" title="'.esc_attr__('Submit', 'trx_utils').'" data-group="'.esc_attr($group ? $group : esc_html__('E-mailer subscription', 'trx_utils')).'">'.esc_attr__('Submit', 'trx_utils').'</a>'
            .'<div class="mcfwp-agree-input">'
            //.'<label class="mcfwp-agree-input"><input type="checkbox" name="i_agree_privacy_policy" value="1" required="" /><span><a href="' . esc_url(get_permalink($page)) .'" target="_blank">I have read and agree to the terms &amp; conditions</a></span></label>'
            .'<label class="mcfwp-agree-input"><input type="checkbox" name="i_agree_privacy_policy" value="1" required="" /><span>'.trim($privacy).'</span></label>'

            .'</div>'
            . '</form>'
			. '</div>';
		return apply_filters('insurance_ancora_shortcode_output', $output, 'trx_emailer', $atts, $content);
	}
	add_shortcode("trx_emailer", "insurance_ancora_sc_emailer");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'insurance_ancora_sc_emailer_reg_shortcodes' ) ) {
	//add_action('insurance_ancora_action_shortcodes_list', 'insurance_ancora_sc_emailer_reg_shortcodes');
	function insurance_ancora_sc_emailer_reg_shortcodes() {
	
		insurance_ancora_sc_map("trx_emailer", array(
			"title" => esc_html__("E-mail collector", 'trx_utils'),
			"desc" => wp_kses_data( __("Collect the e-mail address into specified group", 'trx_utils') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"group" => array(
					"title" => esc_html__("Group", 'trx_utils'),
					"desc" => wp_kses_data( __("The name of group to collect e-mail address", 'trx_utils') ),
					"value" => "",
					"type" => "text"
				),
				"open" => array(
					"title" => esc_html__("Open", 'trx_utils'),
					"desc" => wp_kses_data( __("Initially open the input field on show object", 'trx_utils') ),
					"divider" => true,
					"value" => "yes",
					"type" => "switch",
					"options" => insurance_ancora_get_sc_param('yes_no')
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'trx_utils'),
					"desc" => wp_kses_data( __("Align object to left, center or right", 'trx_utils') ),
					"divider" => true,
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => insurance_ancora_get_sc_param('align')
				), 
				"width" => insurance_ancora_shortcodes_width(),
				"height" => insurance_ancora_shortcodes_height(),
				"top" => insurance_ancora_get_sc_param('top'),
				"bottom" => insurance_ancora_get_sc_param('bottom'),
				"left" => insurance_ancora_get_sc_param('left'),
				"right" => insurance_ancora_get_sc_param('right'),
				"id" => insurance_ancora_get_sc_param('id'),
				"class" => insurance_ancora_get_sc_param('class'),
				"animation" => insurance_ancora_get_sc_param('animation'),
				"css" => insurance_ancora_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'insurance_ancora_sc_emailer_reg_shortcodes_vc' ) ) {
	//add_action('insurance_ancora_action_shortcodes_list_vc', 'insurance_ancora_sc_emailer_reg_shortcodes_vc');
	function insurance_ancora_sc_emailer_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_emailer",
			"name" => esc_html__("E-mail collector", 'trx_utils'),
			"description" => wp_kses_data( __("Collect e-mails into specified group", 'trx_utils') ),
			"category" => esc_html__('Content', 'trx_utils'),
			'icon' => 'icon_trx_emailer',
			"class" => "trx_sc_single trx_sc_emailer",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "group",
					"heading" => esc_html__("Group", 'trx_utils'),
					"description" => wp_kses_data( __("The name of group to collect e-mail address", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "open",
					"heading" => esc_html__("Opened", 'trx_utils'),
					"description" => wp_kses_data( __("Initially open the input field on show object", 'trx_utils') ),
					"class" => "",
					"value" => array(esc_html__('Initially opened', 'trx_utils') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'trx_utils'),
					"description" => wp_kses_data( __("Align field to left, center or right", 'trx_utils') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(insurance_ancora_get_sc_param('align')),
					"type" => "dropdown"
				),
				insurance_ancora_get_vc_param('id'),
				insurance_ancora_get_vc_param('class'),
				insurance_ancora_get_vc_param('animation'),
				insurance_ancora_get_vc_param('css'),
				insurance_ancora_vc_width(),
				insurance_ancora_vc_height(),
				insurance_ancora_get_vc_param('margin_top'),
				insurance_ancora_get_vc_param('margin_bottom'),
				insurance_ancora_get_vc_param('margin_left'),
				insurance_ancora_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Emailer extends Insurance_Ancora_VC_ShortCodeSingle {}
	}
}
?>